var colors = { 
    grapefruit:  'آسمان آبی', 
};
var keys = Object.keys( colors );
var speech = new webkitSpeechRecognition();
speech.language = 'fa-IR';
speech.continuous = true;
speech.interimResults = true;
speech.onresult = function( e ) {
    if ( e.results[e.results.length-1].isFinal) {
      var said = e.results[e.results.length-1][0].transcript.toLowerCase();
      console.log(said);
      output.textContent = said;
      

          if(said=='آسمان آبی'){
              console.log("YES");
          }
        



        for (var i = keys.length - 1; i >= 0; i--) {

            
            //var sanitized_said = said.trim().replace( ' ', '' );

            if ( keys[i] === said ) {
                alert(keys[i]);
                document.body.className = 'body--' + colors[keys[i]];
            } else if ( said === 'remove' || said === 'none' || said === 'clean' ) {
                document.body.className = '';
            }
        };
    };
}

speech.start();