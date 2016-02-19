'use strict';

var sitebackupApp = angular.module('sitebackupApp', []);

sitebackupApp.controller('adminIndexController', function($scope, $http){
    $scope.buttons = {
            archiveCopy : {
                defaultButtonText : 'Сделать новую!',
                buttonText : 'Сделать новую!',
                disabled : false,
                lastCopy : 0
            },
            recursiveCopy : {
                defaultButtonText : 'Сделать!',
                buttonText : 'Сделать!',
                disabled : false,
                lastCopy : 0
            },
            dbCopy : {
                defaultButtonText : 'Сделать!',
                buttonText : 'Сделать!',
                disabled : false,
                lastCopy : 0
            }
    }

    $scope.pressButton = function(action){
        $scope.query = { 'action' : action }
        $scope.buttons[action].buttonText = 'Работаю...';
        $scope.buttons[action].disabled = true;
        $scope.ajaxQuery('backup', $scope.query);
    }

    $scope.ajaxQuery = function(url, data){
        console.log('start');
        $scope.loading = true;
        $http({
            method  : 'POST',
            url     : url,
            data    : data
        })
            .success(function(response) {
                console.log(response);
                if(response > 0){
                    //var date = new Date(response * 1000);
                    $scope.buttons[data.action].lastCopy = 'Успешно! ('+response+')';
                } else {
                    $scope.buttons[data.action].lastCopy = 'Не удалось: '+response;
                }
                $scope.buttons[data.action].buttonText = $scope.buttons[data.action].defaultButtonText;
                $scope.buttons[data.action].disabled = false;
            })
            .error(function(){
                $scope.buttons[data.action].buttonText = $scope.buttons[data.action].defaultButtonText;
                $scope.buttons[data.action].disabled = false;
            })
    }
})