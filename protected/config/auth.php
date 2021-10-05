<?php
return array (
  'updateEvent' => 
  array (
    'type' => 0,
    'description' => 'редактирование мероприятия',
    'bizRule' => NULL,
    'data' => NULL,
  ),
  'deleteEvent' => 
  array (
    'type' => 0,
    'description' => 'удаление мероприятия',
    'bizRule' => NULL,
    'data' => NULL,
  ),
  0 => 
  array (
    'type' => 2,
    'description' => '',
    'bizRule' => NULL,
    'data' => NULL,
    'children' => 
    array (
      0 => 'updateEvent',
    ),
  ),
  1 => 
  array (
    'type' => 2,
    'description' => '',
    'bizRule' => NULL,
    'data' => NULL,
    'children' => 
    array (
      0 => 0,
      1 => 'deleteEvent',
    ),
  ),
);
