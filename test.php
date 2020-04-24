<?php
$data = '#include<stdio.h> 
 
int main(){
printf("Hello World");
return 0;
}
 
';
 
$my_file = 'code.c';
file_put_contents($my_file, $data);
 
system("gcc {$my_file} &> error.txt");
 
$error = file_get_contents("error.txt");
 
if($error=='')
    system("./a.out");
else
    echo $error;
?>