# Event-Bus

A micro event emitting and management system for PHP

### Getting started

The ```true``` parameter passed into the constructor allows for logging of emitted events and their point of call. 
If left empty, it defaults to false which does not keep track hence saving memory.

``` php 
$events = new Events\Events(true);

```

### Basic Implemetation

Within the listener, ```$this``` contains the name of the emitted event ```$this->event```

``` php 
$events = new Events\Events(true);

$events->on('alert', function($message){
  echo($message);
});

$events->emit('alert', 'I love attending to Events');

//  I love attending to Events
```
 
### Basic with multiple parameters
This Emitter would attach to the alert-multi listeners and pass in multiple parameters to it.

``` php 
$events = new Events\Events(true);

$events->on('multi', function($message, $extra1, $extra2, $extra3){
  echo($message . $extra1 . $extra2 . $extra3);
});

$events->emit('multi', 'I love attending to Events ', 'again, ', 'again ', 'and again');

// I love attending to Events again again and again
```

### Multiple Events on a single listener

``` php 
$events = new Events\Events(true);

$events->on('alert | keep', function($message){
  echo($message);
});

$events->emit('keep', 'I love attending to Events ');
$events->emit('alert', 'I love attending to Events ');

// I love attending to Events I love attending to Events
```

### One-time event listeners

``` php 
$events = new Events\Events(true);

$events->once('one-time', function($message){
  echo($message);
});

for ($i=0; $i < 3; $i++) {
  $events->emit('one-time', 'I love attending to just one Event ');
}

// I love attending to just one Event 
```

### Regex style (Namespacing)

``` php 
$events = new Events\Events(true);

$events->on('alert.*', function($message){
  echo($message);
});

$events->emit('alert.regex.one', 'I love attending to Events ');
$events->emit('alert.grep.one', 'I love attending to Events ');
 
// I love attending to Events I love attending to Events
```

### Wrapping up 

Dump all tracked emitters. One can do more with just dumping them on the screen.

``` php 
var_dump($events->log());

```

Check the exmaple file for even more elaborate examples.


### Licence

Copyright (c) 2016 Jeremiah Ogbomo

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is furnished
to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.
