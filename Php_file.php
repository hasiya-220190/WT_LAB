<?php
// This is task2 
//This is a single line comment in php
//This is also  a single line comment  in php
echo "Assalamu alaykum!!<br>How are You?<br>";
echo "Let's start learning Php file operations <br>";
//file_name
$txt_file_name ="Sample.txt";
$folder ="WT";
// file opening and close
print"This is about  file opening and close operations <br>";
if(file_exists($txt_file_name))
//1.file_exists checks whether the file is existing or not
//2opening and closing of a file 
{
 echo"File exists<br>";
 $file=fopen($txt_file_name,"r");
 print "File is opened<br>";//opens the file
 fclose($file);
 echo "File closed<br>";
}
else{
    echo'Unable to Open<br>';
}

//3&4 File read and write
/*before doing anything we have to check whether teh file exists or not
then we have to open and perform the partcular action and then close it */
echo "readyy for the next???<br>";
if(file_exists($txt_file_name)){
    echo "File exists<br>";
    $file=fopen($txt_file_name,"r");
    $contents = fread($file,890);
    echo "read the contents of the file <br>";
    print $contents;
}
    else{
         echo "Unable to read the contents<br>";
        
    }
    //write operation 
    if(file_exists($txt_file_name)){
        $file = fopen($txt_file_name,"w");
        $txt_write = "I'm Hasiya<br>";
        if($file){

          $write= fwrite($file,$txt_write);
          print"Succesfully written $write to the $txt_file_name<br>";
          fclose($file);
        }
        else{
            echo "Can't write<br>";
        }
        //file_get_contents To read the whole file at once 
        $contents_of_file_as_str = file_get_contents($txt_file_name);
        print $contents_of_file_as_str;
    
        $contents_written=file_put_contents($txt_file_name,"How are you doing?");
        print $contents_written;//returning the no.of characters of a file
        echo file_get_contents($txt_file_name);
        $contents_array = file($txt_file_name);   
        print_r ($contents_array);
        //filesize() returns the size of the file
       echo filesize($txt_file_name);
       // returns the filetype
       echo filetype($txt_file_name);
       //fileatime() returns the last access time of the file
       echo date("d-m-Y H:i:s",fileatime($txt_file_name));
       //filemtime() returns the last modified time 
       echo date("d-m-Y H:i:s",filemtime($txt_file_name));
       //filectime() returns the metadata of the file
       echo date("d-m-Y H:i:s",filectime($txt_file_name));
       //fileperms() 
       echo fileperms($txt_file_name);
       //fileowner
       echo fileowner($txt_file_name);
       //fileinode()
        echo fileinode($txt_file_name);
     
        //file_Exists
        if (file_exists($txt_file_name)) {
           echo "File exists";
            }
        //is_file
        if (is_file($txt_file_name)) {
            echo "This is a file";
            }
        rename($txt_file_name,"file_operations");
        copy($txt_file_name, "text.txt");
        unlink($txt_file_name);
        if (is_dir($folder)) {
        echo "This is a folder";
        }
        mkdir($folder);
        rmdir($folder);
        $files = scandir($folder);

foreach ($files as $txt_file) {
    if ($txt_file_name != "." && $txt_file_name != "..") {
        echo $txt_file_name . "<br>";
    }
}
$dir = opendir($folder);

while (($txt_file_name = readdir($dir)) !== false) {
    echo $txt_file_name . "<br>";
}

closedir($dir);

$file = fopen($txt_file_name, "w");

if (flock($txt_file_name, LOCK_EX)) {
    fwrite($txt_file_name, "Writing safely");
    flock($txt_file_name, LOCK_UN);
}

fclose($file);






    }
   

    
    



?>
