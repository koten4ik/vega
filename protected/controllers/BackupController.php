<?php

class BackupController extends FrontEndController
{

    public function actionLoad($table,$db='cre_ru')
    {
        //$dir = 'z:/home/cre/';
        $dir = '/var/lib/mysql-files/';

        // создаем таблицу
        $sql = file_get_contents ($dir.$table.'.struct');
        //todo: портит кодировку
        //Y::sqlExecute('use '.$db.'; '.$sql);

        // загружаем данные
        Y::sqlExecute('LOAD DATA INFILE "'.$dir.$table.'.dat" INTO TABLE '.$db.'.'.$table.';');

    }

    public function actionProcess()
    {
        set_time_limit(3600);

        $temp_dir = '/var/lib/mysql-files/';
        $rezult_dir = '/hosting/www/backup-mysql/';
        $lifetime = 30;// сколько дней храним

        $bases = (Y::sqlQueryAll('SHOW DATABASES LIKE "cre_%"'));
        foreach($bases as $db)
        {
            $db_name = $db['Database (cre_%)'];
            //$db_name = 'cre_book';

            // чистим временную папку
            $t_list = scandir($temp_dir);
            unset($t_list[0],$t_list[1]);
            foreach($t_list as $file) unlink($temp_dir.$file);

            // готовим архив
            $zip = new ZipArchive();
            $filename = $rezult_dir.date('d_m').'_'.$db_name.'.zip';
            if ($zip->open($filename, ZipArchive::CREATE)!==TRUE) exit("can't open <$filename>\n");

            // выгружаем
            foreach(Y::sqlQueryAll('SHOW tables from '.$db_name) as $table)
            {
                // выгружаем данные
                $t_name = $table['Tables_in_'.$db_name];
                Y::sqlExecute('
                    SELECT * INTO OUTFILE \''.$temp_dir.$t_name.'.dat\'
                      LINES TERMINATED BY \'\n\' FROM '.$db_name.'.'.$t_name.';
                ');
                $zip->addFile($temp_dir.$t_name.'.dat',$t_name.'.dat');

                // выгружаем структуру
                $table_struct = Y::sqlQueryAll( 'SHOW CREATE TABLE '.$db_name.'.'.$t_name.';' );
                $table_struct = $table_struct[0]['Create Table'];
                $fp = fopen($temp_dir.$t_name.'.struct', "a");
                fwrite($fp, $table_struct);
                fclose($fp);
                $zip->addFile($temp_dir.$t_name.'.struct',$t_name.'.struct');
            }
            $zip->close();
        }

        // чистим временную папку
        $t_list = scandir($temp_dir);
        unset($t_list[0],$t_list[1]);
        foreach($t_list as $file) unlink($temp_dir.$file);

        // удаляем не актуальные архивы
        $r_list = scandir($rezult_dir);
        unset($r_list[0],$r_list[1]);
        foreach($r_list as $file)
        {
            if( time() - filectime($rezult_dir.$file) > 3600*24*$lifetime )
                unlink($rezult_dir.$file);
        }

    }

}