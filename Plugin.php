<?php
/**
 * 文章字数计算器，实时计算：字数=汉字+数字【此版本只会统计汉字】
 *
 * @package <font color="red">WordCount</font>
 * @author Jrotty
 * @version 1.6
 * @link https://qqdie.com/archives/wordcount-typecho.html
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
?><style>.numtz{-ms-flex-wrap:wrap;flex-wrap:wrap;display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-pack:start;-ms-flex-pack:start;justify-content:flex-start;}.tag{-webkit-box-align:center;-ms-flex-align:center;align-items:center;color:#4a4a4a;display:-webkit-inline-box;display:-ms-inline-flexbox;display:inline-flex;font-size:0.75rem;height:2em;-webkit-box-pack:center;-ms-flex-pack:center;justify-content:center;line-height:1.5;padding-left:0.75em;padding-right:0.75em;white-space:nowrap;margin-bottom:0.5em;}.tag.is-dark{background-color:#363636;color:whitesmoke;}.tag.is-primary{background-color:#00d1b2;color:#fff;}.is-light{background-color:white;color:#363636;}.tag.is-danger{background-color:#ff3860;color:#fff;}.tag.is-info{background-color:#3273dc;color:#fff;}.tag.is-success{background-color:#23d160;color:#fff;}.tag.is-warning{background-color:#ffdd57;color:rgba(0,0,0,0.7);}.tag.hh{background-color: #fc9d3c;color: #fff;}#zimu,#shuzi,#biaoqian,#tunum{margin-left:10px;}</style>
<script>   
var isComposing=false;
document.addEventListener('DOMContentLoaded',function(){   
    var statDiv = document.createElement("div");
    statDiv.className="field is-grouped";
    statDiv.innerHTML='<div class="numtz"><span class="tag">共计：</span><span class="tag is-dark" id="zishu">0</span> <span class="tag is-primary">个字数</span><span class="tag">包含：</span> <span class="tag is-light" id="hanzi">0</span> <span class="tag is-danger">个汉字</span> <span class="tag is-light" id="zimu">0</span> <span class="tag is-success">个字母</span> <span class="tag is-light" id="shuzi">0</span> <span class="tag is-warning">个数字</span> <span class="tag is-light" id="biaoqian">0</span> <span class="tag is-info">个标签</span> <span class="tag is-light" id="tunum">0</span> <span class="tag hh">张图</span></div>';
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
      document.querySelector('#tunum').innerHTML=document.querySelector('#wmd-preview').querySelectorAll('img').length;
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
