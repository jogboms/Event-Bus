<?php

require __DIR__.'/../autoload.php';

$events = new Events\Events(true);

/*
Creating Listeners
 */

// Basic
$events->on('alert', function($message){
  echo($message);
});
// Multiple
$events->on('alert | keep', function($message){
  echo($message);
});

// Regex style (namespacing)
$events->on('alert.*', function($message){
  echo($message);
});

// Namespaced for alert.regex.[anything else] excluding alert.regex it self
$events->on('alert.regex.*', function($message){
  echo($message);
});

// Namespaced for alert.regex.[anything else] including alert.regex as well
$events->on('alert.regex*', function($message){
  echo($message);
});

// Basic with multiple parameter
$events->on('multi', function($message, $extra1, $extra2, $extra3){
  echo($message . $extra1 . $extra2 . $extra3);
});

// One-time event listeners
$events->once('one-time', function($message){
  echo($message);
});

// Default behaviour Multiple times event listeners
$events->on('multiple-time', function($message){
  echo($message);
});


/*
Creating Emitters
 */

/*
This Emitter would attach to the first and second listeners 
since they both contain `alert`
 */
$events->emit('alert', 'I love attending to Events ');

echo('<br /><br />');

/*
This Emitter would attach to the alert-multi listeners and pass in multiple parameters to it
 */
$events->emit('multi', 'I love attending to Events ', 'again, ', 'again ', 'and again');

echo('<br /><br />');

/*
This Emitter would attach to the second listener
since it contain `keep`
 */
$events->emit('keep', 'I love attending to Events ');

echo('<br /><br />');

/*
This Emitter would attach to the third and fifth listener
since it allows for events 'namespaced' with `alert.`, `alert.regex` and `alert.regex.` 
 */
$events->emit('alert.regex', 'I love attending to Events ');

echo('<br /><br />');

/*
This Emitter would attach to the third listener
since it allows for events 'namespaced' with `alert.`
 */
$events->emit('alert.grep.one', 'I love attending to Events ');
echo('<br /><br />');

/*
This Emitter would attach to the third, fourth and fifth listener
since it allows for events 'namespaced' with `alert.`, `alert.regex` and `alert.regex.` 
 */
$events->emit('alert.regex.two', 'I love attending to Events ');

echo('<br /><br />');

/*
This Emitter would only get a one-time listener despite being called multiple times
 */
for ($i=0; $i < 3; $i++) { 
  $events->emit('one-time', 'I love attending to just one Event ');
}

echo('<br /><br />');

/*
Default behaviour: Multiple listeners for every time the event is emitted
 */
for ($i=0; $i < 3; $i++) { 
  $events->emit('multiple-time', 'I love attending to multiple Events ');
  echo('<br />');
}

echo('<br /><br />');

/*
If everytihing went well, this should be the expected out
 */

// 
// I love attending to Events I love attending to Events

// I love attending to Events again, again and again

// I love attending to Events

// I love attending to Events I love attending to Events

// I love attending to Events

// I love attending to Events I love attending to Events I love attending to Events

// I love attending to just one Event

// I love attending to multiple Events
// I love attending to multiple Events
// I love attending to multiple Events
// 


echo('<pre>');

// Print emitted events log since debug is set to true on the constructor
var_dump(
  $events->log()
  );
