/**
* 文字方塊(input,texteare,password)的focus,keydown等事件添加
*/
 

var addFoucsEvent = function (selecter){
 

$(selecter).live({
 

keydown : function (){
var _this = $(this),
placeholder = _this.siblings('.placeholder');
if (_this.val() == '' && placeholder.length != 0){
placeholder.hide();
};
},
keyup : function (ev){
var _this = $(this),
placeholder = _this.siblings('.placeholder');
if (_this.val() == '' && placeholder.length != 0){
if(ev.keyCode == 46 || ev.keyCode == 8){
placeholder.show();
}
}
 

}
});
 

}
addFoucsEvent('.text-entry')