<?php

namespace JProgramowania\ProjectBundle\Components;

class AvailableCarFinder
{
    static protected function joinReservationAndHireArrays($array_cars, $array_reservations, $array_hires)
    {
        $new_array = array();
        foreach($array_cars as $key_cars => $value_cars)
        {
            $new_array[$key_cars]['id'] = $value_cars['id'];
            $new_array[$key_cars]['quantity'] = 0;
        }
        foreach($new_array as $key_new => $value_new)
        {
            foreach($array_reservations as $value_reservations)
            {
                if($new_array[$key_new]['id'] == $value_reservations['id'])
                {
                    $new_array[$key_new]['quantity'] = $new_array[$key_new]['quantity'] + $value_reservations['quantity'];
                }
            }
            foreach($array_hires as $value_hires)
            {
                if($new_array[$key_new]['id'] == $value_hires['id'])
                {
                    $new_array[$key_new]['quantity'] = $new_array[$key_new]['quantity'] + $value_hires['quantity'];
                }
            }
        }
    return $new_array;
    }

    static protected function generateEnableCarsIdList($all_cars_array, $enable_cars_array)
    {
        $new_array = array();
        foreach($all_cars_array as $all_cars_value)
        {
            foreach($enable_cars_array as $enable_cars_value)
            {
                if($all_cars_value['id'] == $enable_cars_value['id'] && $all_cars_value['quantity'] > $enable_cars_value['quantity'])
                {
                    array_push($new_array, $all_cars_value['id']);
                }
            }
        }
        return $new_array;
    }

    static public function getAvailableCarsIdList($all_cars_id_and_quantity, $active_hires_on_cars, $active_reservations_on_cars)
    {
        $active_hires_and_reservations_on_cars = self::joinReservationAndHireArrays($all_cars_id_and_quantity, $active_reservations_on_cars, $active_hires_on_cars);
        return self::generateEnableCarsIdList($all_cars_id_and_quantity, $active_hires_and_reservations_on_cars);
    }
}