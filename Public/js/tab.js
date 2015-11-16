// 鼠标滑过显示  一次引用，实现多个切换
var slides = ["tab01", "tab02","tab03","tab04"];
for(var i=0; i<slides.length; i++){
  var elemTit = document.getElementById(slides[i]).getElementsByTagName("h2")[0].getElementsByTagName("span");
  var elemCon = document.getElementById(slides[i]).getElementsByTagName("ul");
  slide({ handle:elemTit, content:elemCon, current:"current", mode:"mouseover" });
}

// 如果您的页面引用了JQuery，那么这里的引用可以这样写
// slide({handle:$("#tab04 h2 a"), content:$("#tab04 ul"), current:"current", mode:"click"});