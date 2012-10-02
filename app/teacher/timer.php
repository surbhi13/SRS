<h1>Countdown Timer: &nbsp; <span id="showmns">00</span>:<span id="showscs">00</span></h1>
<script type="text/javascript"><!--
    /* Function to display a Countdown timer with starting time from a form */
// sets variables for minutes and seconds
var ctmnts = 0;
var ctsecs = 0;
var startchr = 0;       // used to control when to read data from form

function countdownTimer() {

  // http://www.coursesweb.net/javascript/
  // if $startchr is 0, and form fields exists, gets data for minutes and seconds, and sets $startchr to 1
  if(startchr == 0 && document.getElementsByName('mns') && document.getElementsByName('scs')) {
    // makes sure the script uses integer numbers
    ctmnts = parseInt(document.getElementsByName('mns').value) + 0;
    ctsecs = parseInt(document.getElementsByName('scs').value) * 1;

    // if data not a number, sets the value to 0
    if(isNaN(ctmnts)) ctmnts = 0;
    if(isNaN(ctsecs)) ctsecs = 0;

    // rewrite data in form fields to be sure that the fields for minutes and seconds contain integer number
    document.getElementsByName('mns').value = ctmnts;
    document.getElementsByName('scs').value = ctsecs;
    startchr = 1;
    document.getElementsByName('btnct').setAttribute('disabled', 'disabled');     // disable the button
  }

  // if minutes and seconds are 0, sets $startchr to 0, and return false
  if(ctmnts==0 && ctsecs==0) {
    startchr = 0;
    document.getElementsById('btnct').removeAttribute('disabled');     // remove "disabled" to enable the button

    /* HERE YOU CAN ADD TO EXECUTE A JavaScript FUNCTION WHEN COUNTDOWN TIMER REACH TO 0 */

    return false;
  }
  else {
    // decrease seconds, and decrease minutes if seconds reach to 0
    ctsecs--;
    if(ctsecs < 0) {
      if(ctmnts > 0) {
        ctsecs = 59;
        ctmnts--;
      }
      else {
        ctsecs = 0;
        ctmnts = 0;
      }
    }
  }

  // display the time in page, and auto-calls this function after 1 seccond
  document.getElementsByName('showmns').innerHTML = ctmnts;
  document.getElementsByName('showscs').innerHTML = ctsecs;
  setTimeout('countdownTimer()', 1000);
}
//-->
</script>
