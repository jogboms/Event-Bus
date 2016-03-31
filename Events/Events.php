<?php

namespace Events;

Class EventsException extends \Exception {}

Class Events
{
  /**
  * @var boolean All logging of events
  */
  protected $debug = false;
  /**
  * @var array Contains all declared events
  */
  protected $__events = [];
  /**
  * @var array Contains all emitted events and its location
  */
  protected $__events_log = [];
  /**
  * @var Delimiter used to separate multiple event_names
  */
  protected $__separator = '|';

  /**
   * Create an Instance of the Bus
   * @param  boolean $debug Set debug parameter
   */
  public function __construct($debug = false)
  {
    $this->debug = $debug;
  }

  /**
   * Listen once to an event or multiples of events using | as separator
   * @param  string $event_name Name of event to listen to
   * @param  callable $callable   Callable to invoke when the event is emitted
   *                              This callable should contain the same number of parameters expected to recieve from the listener
   *                              and in the order at which it is expected.
   * @return self
   */
  public function once($event_name, $callable)
  {
    return $this->on($event_name, $callable, true);
  }

  /**
   * Listen to an event or multiples of events using | as separator
   * @param  string $event_name Name of event to listen to
   * @param  callable $callable   Callable to invoke when the event is emitted. 
   *                              This callable contains the same number of parameters passed to the event
   *                              At any pointit was emitted and in the order at which it was constructed.
   * @return self
   */
  public function on($event_name, $callable, $once = false)
  {
    $event[] = $callable;

    if($once === true)
      $event['once'] = true;
    /* Incase of multiple events seperated by | */
    $events = explode($this->__separator, $event_name);
    foreach ($events as $event_name) {
      // Allow for name-spacing
      $this->__events[trim(str_replace('*', '.*', $event_name))][] = $event;
    }
    return $this;
  }

  /**
   * Switch off all listeners on a particular event or all events
   * @param  string|null $event_name Setting $event_name to null or leaving it empty removes all event listeners.
   *                                 Other wiseuse the event's name
   * @return self
   */
  public function off($event_name = null)
  {
    if($event_name === null){
      $this->__events = [];
    } else {
      unset($this->__events[$event_name]);
    }
    return $this;
  }
  /**
   * Emit Events
   * @param  string $event_name Event name
   * @example ->emit($event_name [, ...])
   * @throws EventsException
   * @return self
   */
  public function emit($event_name)
  {
    $args = func_get_args();
    $event_name = array_shift($args);

    if($this->debug){
      list($e) = debug_backtrace();
      $this->__events_log[] = [$event_name, basename($e['file']), $e['line']];
    }

    /* When it is a Regex-called event */
    foreach($this->__events as $key => &$events){
      if(preg_match('~^'.$key.'$~', $event_name)){
        if(empty($events)) return;


        foreach($events as $event){
          if(!is_callable($event[0]))
            throw new EventsException('Event listener `'.$event_name.'` requires a valid listener function');

          $class = new \stdClass();
          $class->event = $event_name;

          call_user_func_array($event[0]->bindTo($class), $args);
        }

        /* stops this Event from running Multiple times */
        if(isset($events[0]['once'])){
          unset($events[0]);
        }
      }
    }
    return $this;
  }

  /**
   * Get names of all listeners
   * @return array
   */
  public function events()
  {
    return array_keys($this->__events);
  }

  /**
   * Get all emitted events and their point of emit
   * @return array
   */
  public function log()
  {
    return $this->__events_log;
  }
}
