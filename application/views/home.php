<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<br>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-danger text-center" id="result"></div>
        </div>
        <?php $words = ['Hello', 'World', 'Lorem', 'ipsum', 'dolor', 'sit', 'amet', 'consectetur', 'adipisicing', 'elit.', 'Consequatur', 'quae', 'necessitatibus,', 'reprehenderit', 'reiciendis', 'quam', 'temporibus.', 'Porro', 'libero', 'vel', 'labore', 'quod', 'neque,', 'totam', 'iusto', 'at', 'deserunt', 'minima', 'animi', 'mollitia', 'vero', 'illum?'] ?>
        <div class="col-md-12" id="words">
            <?php foreach($words as $word): ?>
                <button class="btn btn-success"><?= $word ?></button>
            <?php endforeach ?>
        </div>
        <div class="col-md-12">
            <br>
            <button class="btn btn-primary" onclick="speak()">Result</button>
        </div>
        <div class="col-md-12">
            <br>
            <button id='btnGiveCommand' class="btn btn-primary">Give Command!</button>
        </div>
        <div id='message' class="col-md-12"></div>
        <div class="col-md-10">
            <input type="text" id="text" class="form-control">
        </div>
        <div class="col-md-2">
            <button onclick="make()" class="btn btn-primary col-md-12">Click</button>
        </div>
    </div>
</div>

<script>
    function make(str){
        var msg = new SpeechSynthesisUtterance();
        msg.volume = 1; // From 0 to 1
        msg.rate = 0.6; // From 0.1 to 10
        msg.pitch = 0; // From 0 to 2
        // msg.text = str;
        msg.text = document.getElementById('text').value;
        msg.lang = 'en';
        speechSynthesis.speak(msg);
        speechSynthesis.onerror = function(event) {
            console.log(event.error)
        }   
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
<script>
    words = document.getElementsByClassName('btn-success');
    
    for (var i = 0; i < words.length; i++) {
        words[i].addEventListener('click',buttonClick,false);
    }

    function buttonClick(ev){
        if ($(ev.target).hasClass('result')){
            $(ev.target).removeClass('result');
            $(ev.target).addClass('word');
            $('#words').append(ev.target);
        }else{
            $(ev.target).removeClass('word');
            $(ev.target).addClass('result');
            $('#result').append(ev.target);
        }
    }

    function speak(){
        let result = document.getElementsByClassName('result');
        let txt = '';
        for (var i = 0; i < result.length; i++) {
            txt += words[i].innerHTML+' ';
        }
        document.getElementById('text').value = txt;
        make();
    }
</script>