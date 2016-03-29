# Event-Bus
A micro event emitting and management system for PHP

### Basic Event Bus Implemetation

Within the listener, ```$this``` contains the name of the emitted event ```$this->event```

``` php 
 Events::on('alert', function($message [, ...]){
      echo($message);
 });
 Events::emit('alert', 'I love attending Events');

 //  [output] I love attending Events
 ```
 
 ### Multiple Events on a single callback
 
``` php 
 Events::on('alert | keep', function($message [, ...]){
      echo($message);
 });
 Events::emit('keep', 'I love attending Events ');
 Events::emit('alert', 'I love attending Events ');

// [output] I love attending Events I love attending Events

 ```

 ### Regex style
 
``` php 
 Events::on('alert.*', function($message [, ...]){
      echo($message);
 });
 Events::emit('alert.regex.one', 'I love attending Events ');
 Events::emit('alert.regex.two', 'I love attending Events ');
 
 // [output] I love attending Events I love attending Events
 ```
