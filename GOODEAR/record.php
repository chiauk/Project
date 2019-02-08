<!DOCTYPE html>

<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <link rel="Shortcut Icon" type="image/x-icon" href="img/GERlogo.png" />
	<title>GoodEaR 開口學發音</title>
  <style type='text/css'>
    body{ 
      font-family: 微軟正黑體; 
      background-image: url(images/GER.png);
      margin-left: 30px;
    }
    ul { list-style: none; }
    #recordingslist audio { display: block; margin-bottom: 10px; }
  </style>
</head>
<body>
  <div class="wrap">
    <div class="header">
      <h1>錄下自己的聲音來聽聽吧</h1>
    </div>
    <div class="content">
      <button onclick="startRecording(this);">錄音</button>
      <button onclick="stopRecording(this);" disabled>停止</button>
      
      <h2>練習音檔</h2>
      <ul id="recordingslist"></ul>
      
      <h2>小提示</h2>
      <pre id="log"></pre>

      <script>
      function __log(e, data) {
        log.innerHTML += "\n" + e + " " + (data || '');
      }

      var audio_context;
      var recorder;

      function startUserMedia(stream) {
        var input = audio_context.createMediaStreamSource(stream);
        recorder = new Recorder(input);
        //錄音功能初始化完成
      }

      function startRecording(button) {
        recorder && recorder.record();
        button.disabled = true;
        button.nextElementSibling.disabled = false;
        __log('開始錄音');
      }

      function stopRecording(button) {
        recorder && recorder.stop();
        button.disabled = true;
        button.previousElementSibling.disabled = false;
        __log('停止錄音');
        
        //產生wav音檔
        createDownloadLink();
        
        recorder.clear();
      }

      function createDownloadLink() {
        recorder && recorder.exportWAV(function(blob) {
          var url = URL.createObjectURL(blob);
          var li = document.createElement('li');
          var au = document.createElement('audio');
          var hf = document.createElement('a');
          
          au.controls = true;
          au.src = url;
          hf.href = url;
          hf.download = new Date().toISOString() + '.wav';
          hf.innerHTML = hf.download;
          li.appendChild(au);
          li.appendChild(hf);
          recordingslist.appendChild(li);
        });
      }

      window.onload = function init() {
        try {
          window.AudioContext = window.AudioContext || window.webkitAudioContext;
          navigator.getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMedia;
          window.URL = window.URL || window.webkitURL;
          
          audio_context = new AudioContext;
          __log('錄音小精靈' + (navigator.getUserMedia ? '準備好囉' : '還沒準備好'));
        } catch (e) {
          alert('請檢查網站是否缺少音源設備唷');
        }
        
        navigator.getUserMedia({audio: true}, startUserMedia, function(e) {
          __log('缺少音源輸入: ' + e);
        });
      };
      </script>

      <script src="js/recorder.js"></script>
    </div>
    <div class="footer"></div>
  </div>
</body>
</html>
