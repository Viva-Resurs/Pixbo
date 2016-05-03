var gulp = require('gulp');
var shell = require('gulp-shell');
var Elixir = require('laravel-elixir');

var Task = Elixir.Task;

Elixir.extend('jsonConcat', function(message) {

    new Task('speak', function() {
        return gulp.src('').pipe(shell('echo ' + message));
    });

});