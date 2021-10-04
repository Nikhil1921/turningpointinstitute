<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<button id='btnGiveCommand'>Give Command!</button>
<br><br>
<span id='message'></span>
<div id="meet">
</div>

<!-- <input type="text" id="text">
<button onclick="make()">Click</button> -->
<script src='https://meet.jit.si/external_api.js'></script>

<script>
    const domain = 'meet.jit.si';
    const options = {
        roomName: 'densetek',
        width: 700,
        height: 700,
        /* devices: {
            audioInput: '<deviceLabel>',
            audioOutput: '<deviceLabel>',
            videoInput: '<deviceLabel>'
        }, */
        parentNode: document.querySelector('#meet')
    };
    const api = new JitsiMeetExternalAPI(domain, options);
    api.captureLargeVideoScreenshot().then(data => {
        console.log(data)
        // data is an Object with only one param, dataURL
        // data.dataURL = "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAABQAA..."
    });
    function make(str){
        var msg = new SpeechSynthesisUtterance();
        msg.volume = 1; // From 0 to 1
        msg.rate = 0.6; // From 0.1 to 10
        msg.pitch = 0; // From 0 to 2
        msg.text = str;
        // msg.text = document.getElementById('text').value;
        msg.lang = 'en';
        speechSynthesis.speak(msg);
    }

    var message = document.querySelector('#message');

    var SpeechRecognition = SpeechRecognition || webkitSpeechRecognition;
    var SpeechGrammarList = SpeechGrammarList || webkitSpeechGrammarList;

    // var grammar = '#JSGF V1.0;'

    var recognition = new SpeechRecognition();
    var speechRecognitionList = new SpeechGrammarList();
    // speechRecognitionList.addFromString(grammar, 1);
    recognition.grammars = speechRecognitionList;
    recognition.lang = 'en-US';
    recognition.interimResults = false;

    recognition.onresult = function(event) {
        var last = event.results.length - 1;
        var command = event.results[last][0].transcript;
        make(command);
        message.textContent = 'Voice Input: ' + command + '.';

        /* if(command.toLowerCase() === 'select steve'){
            document.querySelector('#chkSteve').checked = true;
        }    */
    };

    recognition.onspeechend = function() {
        recognition.stop();
    };

    recognition.onerror = function(event) {
        message.textContent = 'Error occurred in recognition: ' + event.error;
    }        

    document.querySelector('#btnGiveCommand').addEventListener('click', function(){
        recognition.start();
    });
</script>