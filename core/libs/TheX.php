<?php

    abstract class X
    {

        public $cl_name;
        // $cl_name - название класса.
        // Зачем?
        // Все просто: Потому что чтобы получить имя класса, вместо $TheX->name нужно было бы использовать get_class($some_long_name_of_object)
        // ps. Расмус - не силен в чистом коде, ибо get_class может значить что угодно. (в том числе и, конечно, название класса)

        function reset_object_fields($fields_names_in_string = 'cl_name')
        {
            echo get_class($this);
        }

        // reset_object_fields
        // Функция была написана для Vay.im, чтобы не создавать новый экземпляр класса User, ибо это оперативка.
        // Redis может позволять стучать в RAM сколько угодно, но Php кушает больше.
        // pps. Возможно, этот способ сохранить память настолько же эффективен, насколько и эффективно использование одинарных кавычек.
        // Юнит тесты сделает Хабрахабр))

        function get_class_name()
        {
            return $this->cl_name;
        }

        static function abort($object)
        {
            if(DEBUG)
                echo 'theX system aborting...<br><hr>';

            var_dump($object);

            die();
        }

    }