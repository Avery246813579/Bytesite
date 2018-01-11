/**
 * Created by Avery on 7/17/2015.
 */
var clsStopwatch = function () {
    // Private vars
    var startAt = 0;	// Time of last start / resume. (0 if not running)
    var lapTime = 0;	// Time on the clock when last stopped in milliseconds

    var now = function () {
        return (new Date()).getTime();
    };

    // Public methods
    // Start or resume
    this.start = function () {
        startAt = startAt ? startAt : now();
    };

    // Stop or pause
    this.stop = function () {
        // If running, update elapsed time otherwise keep it
        lapTime = startAt ? lapTime + now() - startAt : lapTime;
        startAt = 0; // Paused
    };

    // Reset
    this.reset = function () {
        lapTime = startAt = 0;
    };

    // Duration
    this.time = function () {
        return lapTime + (startAt ? now() - startAt : 0);
    };
};

var x = new clsStopwatch();
var $time;
var clocktimer;
var add = 0;

function pad(num, size) {
    var s = "0000" + num;
    return s.substr(s.length - size);
}

function formatTime(time) {
    var h = m = s = ms = 0;
    var newTime = '';

    time = time + add;
    h = Math.floor(time / (60 * 60 * 1000));
    time = time % (60 * 60 * 1000);
    m = Math.floor(time / (60 * 1000));
    time = time % (60 * 1000);
    s = Math.floor(time / 1000);

    newTime = pad(h, 2) + ':' + pad(m, 2) + ':' + pad(s, 2);
    return newTime;
}

function show() {
    $time = document.getElementById('time');
    update();
}

function update() {
    $time.innerHTML = formatTime(x.time());
}

function start() {
    clocktimer = setInterval("update()", 1);
    x.start();
}

function add_sec(){
    add = add + 1000;
    update();
}

function add_min(){
    add = add + (1000 * 60);
    update();
}


function add_hour(){
    add = add + (1000 * 60) * 60;
    update();
}

function remove_sec(){
    add = add - 1000;
    update();
}

function remove_min(){
    add = add - (1000 * 60);
    update();
}


function remove_hour(){
    add = add - (1000 * 60) * 60;
    update();
}

function stop() {
    x.stop();
    clearInterval(clocktimer);
}

function reset() {
    stop();
    x.reset();
    update();
}
