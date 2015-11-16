    var number=2;
    function LMYC() {
    var lbmc;
    var treePic;
        for (i=1;i<=number;i++) {
            lbmc = document.getElementById('ME' + i );
            treePic = document.getElementById('treePic'+i);
            treePic.src = 'images/xl01.gif';
            lbmc.style.display = 'none';
        }
    }
     
    function ShowFLT(i) {
        lbmc = document.getElementById('ME' + i );
        treePic = document.getElementById('treePic' + i)
        if (lbmc.style.display == 'none') {
            LMYC();
            treePic.src = 'images/xl.gif';
            lbmc.style.display = '';
        }
        else {
            treePic.src = 'images/xl01.gif';
            lbmc.style.display = 'none';
        }
    }
    
    function showURL(id){
       var ss=id.title;
       var str=window.top.document.getElementById("ShowInfo").firstChild.nodeValue;
       var st =""; 
       if (str.indexOf(">>") == str.lastIndexOf(">>") ){
           st=str;
       }
       else{
          st = str.substring(0, str.lastIndexOf(">>")-1);
       }
       window.top.document.getElementById("ShowInfo").firstChild.nodeValue=st+" >> "+ss;
    }