/**********************************************************************
                           Simple marquee script
                      By Mark Wilton-Jones 25/6/2005
***********************************************************************

Please see http://www.howtocreate.co.uk/jslibs/ for details and a demo of this script
Please see http://www.howtocreate.co.uk/jslibs/termsOfUse.html for terms of use

The <marquee> tag is not part of the HTML or XHTML standards, and as a result, it
is not supported cross browser. The marquee effect can be important for displaying
messages on devices with small screens, or in a position on web pages where space
is limited. This script produces a simple marquee effect that works cross browser
without invalidating your document. In addition, the effect is accessible, and
degrades gracefully in non-DOM browsers to show the text normally.

To use:

Inbetween the <head> tags, put:

	<script src="PATH TO SCRIPT/simplemarquee.js" type="text/javascript"></script>

Then wherever you want to define a marquee, use:

	<div class="dmarquee"><div><div>Marquee text</div></div></div>

You can create multiple marquees if needed. If you want to style the marquees, style
the outermost div (the script uses the inner divs to avoid box model problems). You
can use multiple classes to the outer div to facilitate additional styling:

	<div class="dmarquee myclass"><div><div>Marquee text</div></div></div>

To stop the marquees manually, run doMStop();
You can also restart them using doDMarquee();

You can set a few options using the variables below. I have no intention of making
additional options in this script. Marquees can be very annoying if used as a special
effect where they are not actually needed, and I do not want to encourage their use.
If you want to make additional options, you can go ahead, but I will not help you.
________________________________________________________________________________*/

var oMarquees = [], oMrunning,
	oMInterv =        20,     //interval between increments
	oMStep =          1,      //number of pixels to move between increments
	oStopMAfter =     0,     //how many seconds should marquees run (0 for no limit)
	oResetMWhenStop = false,  //set to true to allow linewrapping when stopping
	oMDirection =     'left'; //'left' for LTR text, 'right' for RTL text

/***     Do not edit anything after here     ***/

function doMStop() {
	clearInterval(oMrunning);
	for( var i = 0; i < oMarquees.length; i++ ) {
		oDiv = oMarquees[i];
		oDiv.mchild.style[oMDirection] = '0px';
		if( oResetMWhenStop ) {
			oDiv.mchild.style.cssText = oDiv.mchild.style.cssText.replace(/;white-space:nowrap;/g,'');
			oDiv.mchild.style.whiteSpace = '';
			oDiv.style.height = '';
			oDiv.style.overflow = '';
			oDiv.style.position = '';
			oDiv.mchild.style.position = '';
			oDiv.mchild.style.top = '';
		}
	}
	oMarquees = [];
}
function doDMarquee() {
	if( oMarquees.length || !document.getElementsByTagName ) { return; }
	var oDivs = document.getElementsByTagName('div');
	for( var i = 0, oDiv; i < oDivs.length; i++ ) {
		oDiv = oDivs[i];
		if( oDiv.className && oDiv.className.match(/\bdmarquee\b/) ) {
			if( !( oDiv = oDiv.getElementsByTagName('div')[0] ) ) { continue; }
			if( !( oDiv.mchild = oDiv.getElementsByTagName('div')[0] ) ) { continue; }
			oDiv.mchild.style.cssText += ';white-space:nowrap;';
			oDiv.mchild.style.whiteSpace = 'nowrap';
			oDiv.style.height = oDiv.offsetHeight + 'px';
			oDiv.style.overflow = 'hidden';
			oDiv.style.position = 'relative';
			oDiv.mchild.style.position = 'absolute';
			oDiv.mchild.style.top = '0px';
			oDiv.mchild.style[oMDirection] = oDiv.offsetWidth + 'px';
			oMarquees[oMarquees.length] = oDiv;
			i += 2;
		}
	}
	oMrunning = setInterval('aniMarquee()',oMInterv);
	if( oStopMAfter ) { setTimeout('doMStop()',oStopMAfter*1000); }
}
function aniMarquee() {
	var oDiv, oPos;
	for( var i = 0; i < oMarquees.length; i++ ) {
		oDiv = oMarquees[i].mchild;
		oPos = parseInt(oDiv.style[oMDirection]);
		if( oPos <= -1 * oDiv.offsetWidth ) {
			oDiv.style[oMDirection] = oMarquees[i].offsetWidth + 'px';
		} else {
			oDiv.style[oMDirection] = ( oPos - oMStep ) + 'px';
		}
	}
}
if( window.addEventListener ) {
	window.addEventListener('load',doDMarquee,false);
} else if( document.addEventListener ) {
	document.addEventListener('load',doDMarquee,false);
} else if( window.attachEvent ) {
	window.attachEvent('onload',doDMarquee);
}