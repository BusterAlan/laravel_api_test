<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class HabitHandler extends Controller {

    public function insertDayChecked(Request $request) {

        $data = $request -> json() -> all();

        $id_user = $data['id_user'];
        $num_habit = $data['num_habit'];
        $num_day = $data['num_day'];

        DB::insert(

            'INSERT into day_habit_info (id_user, num_habit, num_day) values (?, ?, ?)',
            [$id_user, $num_habit, $num_day]

        );

        return response() -> json(

            [

                "message" => "Sucessfully info inserted :)"

            ], Response::HTTP_OK // 200

        );

    }

    public function updateFinished(Request $request) {

        $data = $request -> json() -> all();

        $id_user = $data['id_user'];
        $num_habit = $data['num_habit'];
        $num_day = $data['num_day'];
        $editActualDate = $data['editActualDate'];

        $day_clicked = DB::table('day_habit_info')

        -> where('id_user', $id_user)
        -> where('num_habit', $num_habit)
        -> where('num_day', $num_day)
        -> value('day_clicked');

        if ($day_clicked) {

            $dateDiff = DB::select(

                'SELECT DATEDIFF(current_timestamp(), ?) as diff',
                [$day_clicked]

            );

            if ($dateDiff[0] -> diff < 1) {

                return response() -> json([

                    'message' => 'Debe pasar al menos un día desde el inicio'

                ], Response::HTTP_CONFLICT); // 409

            }

            ($editActualDate == null) ? DB::update(

                'UPDATE

                day_habit_info

                set

                day_finished = current_timestamp()

                where

                id_user = ? and num_habit = ? and num_day = ?',
                [$id_user, $num_habit, $num_day]

            ) : DB::update(

                'UPDATE

                day_habit_info

                set

                day_clicked = current_timestamp()

                where

                id_user = ? and num_habit = ? and num_day = ?',
                [$id_user, $num_habit, $num_day]

            );

            return response() -> json([

                'message' => 'Hábito actualizado correctamente'

            ], Response::HTTP_OK); // 200

        } else {

            return response() -> json([

                'message' => 'Registro no encontrado'

            ], Response::HTTP_NOT_FOUND);

        }

    }

    public function evalProgress($id_user) {

        $infoGeneral = DB::select(

            'SELECT

            habitOrder

            from habits

            where id_user = ?',

            [$id_user]

        );

        $habitOrders = array_map(function($row) {

            return $row -> habitOrder;

        }, $infoGeneral);

        $maxHabitOrder = empty($habitOrders) ? 0 : max($habitOrders);

        $dayCheckEval = DB::select(

            'SELECT

            num_day

            from

            day_habit_info

            where

            id_user = ?
            and
            num_habit = ? + 1
            and
            day_finished is not null',

            [$id_user, $maxHabitOrder]

        );

        $numDays = array_map(function($row) {

            return $row->num_day;

        }, $dayCheckEval);

        return response() -> json(

            [

                "listHabitsCompleted" => $numDays,
                "habitCompletedProgress" => $maxHabitOrder

            ], Response::HTTP_OK

        );

    }

}

