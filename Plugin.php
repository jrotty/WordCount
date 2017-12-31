<?php
/**
 * 文章字数计算器，实时计算：字数=汉字+数字【此版本只会统计汉字】
 *
 * @package <font color="red">WordCount</font>
 * @author Jrotty
 * @version 1.5
 * @link https://github.com/jrotty/WordCount
 */
class WordCount_Plugin implements Typecho_Plugin_Interface
{
    /**
     * 插件版本号
     * @var string
     *
     *
     * 激活插件方法,如果激活失败,直接抛出异常
     *
     * @access public
     * @return void
     * @throws Typecho_Plugin_Exception
     */
    public static Function activate()
    {
		Typecho_Plugin::factory('admin/write-post.php')->bottom = array('WordCount_Plugin', 'num');
		Typecho_Plugin::factory('admin/write-page.php')->bottom = array('WordCount_Plugin', 'num');
	}
public static function num(){
		?><style>
.field.is-grouped{margin-top:10px;display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-pack:start;-ms-flex-pack:start;justify-content:flex-start;  -ms-flex-wrap: wrap;flex-wrap: wrap;}.field.is-grouped>.control{-ms-flex-negative:0;flex-shrink:0}.field.is-grouped>.control:not(:last-child){margin-bottom:.5rem;margin-right:.75rem}.field.is-grouped>.control.is-expanded{-webkit-box-flex:1;-ms-flex-positive:1;flex-grow:1;-ms-flex-negative:1;flex-shrink:1}.field.is-grouped.is-grouped-centered{-webkit-box-pack:center;-ms-flex-pack:center;justify-content:center}.field.is-grouped.is-grouped-right{-webkit-box-pack:end;-ms-flex-pack:end;justify-content:flex-end}.field.is-grouped.is-grouped-multiline{-ms-flex-wrap:wrap;flex-wrap:wrap}.field.is-grouped.is-grouped-multiline>.control:last-child,.field.is-grouped.is-grouped-multiline>.control:not(:last-child){margin-bottom:.75rem}.field.is-grouped.is-grouped-multiline:last-child{margin-bottom:-.75rem}.field.is-grouped.is-grouped-multiline:not(:last-child){margin-bottom:0}.tags{-webkit-box-align:center;-ms-flex-align:center;align-items:center;display:-webkit-box;display:-ms-flexbox;display:flex;-ms-flex-wrap:wrap;flex-wrap:wrap;-webkit-box-pack:start;-ms-flex-pack:start;justify-content:flex-start}.tags .tag{margin-bottom:.5rem}.tags .tag:not(:last-child){margin-right:.5rem}.tags:last-child{margin-bottom:-.5rem}.tags:not(:last-child){margin-bottom:1rem}.tags.has-addons .tag{margin-right:0}.tags.has-addons .tag:not(:first-child){border-bottom-left-radius:0;border-top-left-radius:0}.tags.has-addons .tag:not(:last-child){border-bottom-right-radius:0;border-top-right-radius:0}.tag{-webkit-box-align:center;-ms-flex-align:center;align-items:center;background-color:#f5f5f5;border-radius:3px;color:#4a4a4a;display:-webkit-inline-box;display:-ms-inline-flexbox;display:inline-flex;font-size:.75rem;height:2em;-webkit-box-pack:center;-ms-flex-pack:center;justify-content:center;line-height:1.5;padding-left:.75em;padding-right:.75em;white-space:nowrap}.tag .delete{margin-left:.25em;margin-right:-.375em}.tag.is-white{background-color:#fff;color:#0a0a0a}.tag.is-black{background-color:#0a0a0a;color:#fff}.tag.is-light{background-color:#fff;color:#363636}.tag.is-dark{background-color:#363636;color:#f5f5f5}.tag.is-primary{background-color:#00d1b2;color:#fff}.tag.is-info{background-color:#3273dc;color:#fff}.tag.is-success{background-color:#23d160;color:#fff}.tag.is-warning{background-color:#ffdd57;color:rgba(0,0,0,.7)}.tag.is-danger{background-color:#ff3860;color:#fff}.tag.is-large{font-size:1.25rem}.tag.is-delete{margin-left:1px;padding:0;position:relative;width:2em}.tag.is-delete:after,.tag.is-delete:before{background-color:currentColor;content:"";display:block;left:50%;position:absolute;top:50%;-webkit-transform:translateX(-50%) translateY(-50%) rotate(45deg);transform:translateX(-50%) translateY(-50%) rotate(45deg);-webkit-transform-origin:center center;transform-origin:center center}.tag.is-delete:before{height:1px;width:50%}.tag.is-delete:after{height:50%;width:1px}.tag.is-delete:focus,.tag.is-delete:hover{background-color:#e8e8e8}.tag.is-delete:active{background-color:#dbdbdb}.tag.is-rounded{border-radius:290486px}
</style>
<script>   
var isComposing=false;
document.addEventListener('DOMContentLoaded',function(){   
    var statDiv = document.createElement("div");
    statDiv.className="field is-grouped";
    statDiv.innerHTML='<div class="field is-grouped"><span class="tag">共计：</span><div class="control"><div class="tags has-addons"><span class="tag is-dark" id="zishu">0</span> <span class="tag is-primary">个字数</span></div></div><span class="tag">包含：</span><div class="control"><div class="tags has-addons"><span class="tag is-light" id="hanzi">0</span> <span class="tag is-danger">个汉字</span></div></div><div class="control"><div class="tags has-addons"><span class="tag is-light" id="zimu">0</span> <span class="tag is-success">个字母</span></div></div><div class="control"><div class="tags has-addons"><span class="tag is-light" id="shuzi">0</span> <span class="tag is-warning">个数字</span></div></div><div class="control"><div class="tags has-addons"><span class="tag is-light" id="biaoqian">0</span> <span class="tag is-info">个标签</span></div></div></div>';
  document.querySelector("#wmd-editarea").after(statDiv);
  document.querySelector('#wmd-editarea textarea').addEventListener('keyup',handleStat);
    document.querySelector('#wmd-editarea textarea').addEventListener('compositionstart',function(){isComposing=true;});
    document.querySelector('#wmd-editarea textarea').addEventListener('compositionend',function(){isComposing=false;});
   handleStat();tagsnum();
});
function handleStat(){
    if(!isComposing){
        Words = document.querySelector('#wmd-preview').textContent;
      var iTotal = 0;
      var inum = 0;
      var znum = 0;
        for (i = 0; i < Words.length; i++) {
            var c = Words.charAt(i);
            if (c.match(/[a-zA-Z]/)) {
                znum++;
            }
            if (c.match(/[\u4e00-\u9fa5]/)) {
                iTotal++;
            }
                if (c.match(/[0-9]/)) {
                inum++;
            }

        }
      

      document.getElementById('zishu').innerText = inum + iTotal;
        document.getElementById('zimu').innerText = znum;
        document.getElementById('shuzi').innerText = inum;
      document.getElementById('hanzi').innerText = iTotal;
    }
}
    function tagsnum(){ 
  var biaoqian = 0;
biaoqian = $(".token-input-list").find("li").length;
document.getElementById("biaoqian").innerHTML = biaoqian - 1;
setTimeout('tagsnum()', 200); 
} 
</script>
<?php
}
	
    /**
     * 获取插件配置面板
     *
     * @access public
     * @param Typecho_Widget_Helper_Form $form 配置面板
     * @return void
     */
    public static function config(Typecho_Widget_Helper_Form $form){}
    /**
     * 个人用户的配置面板
     *
     * @access public
     * @param Typecho_Widget_Helper_Form $form
     * @return void
     */
    public static function personalConfig(Typecho_Widget_Helper_Form $form){}
    /**
     * 禁用插件方法,如果禁用失败,直接抛出异常
     *
     * @static
     * @access public
     * @return void
     * @throws Typecho_Plugin_Exception
     */
    public static function deactivate(){}
}
