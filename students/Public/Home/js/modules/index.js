layui.use(['form', 'layedit', 'laydate'], function(){
  var form = layui.form()
  ,layer = layui.layer
  ,layedit = layui.layedit
  ,laydate = layui.laydate;
 
  //自定义验证规则
  form.verify({
    title: function(value){
      if(value.length < 5){
        return '标题至少得5个字符啊';
      }
    }
    ,pass: [/(.+){6,12}$/, '密码必须6到12位']
  });
  
  //创建一个编辑器
  layedit.build('LAY_demo_editor');
  
  //监听提交
  form.on('submit(demo1)', function(data){
    layer.alert(JSON.stringify(data.field), {
      title: '最终的提交信息'
    })
    return false;
  });
  
  
});

//----------------------------------------------------------------------------------------------------------------------

layui.use('layer', function(){ //独立版的layer无需执行这一句
  var $ = layui.jquery, layer = layui.layer; //独立版的layer无需执行这一句
  
  //触发事件
  var active = {
    setTop: function(){
      var that; 
      layer.open({
        type: 2 //此处以iframe举例
        ,title: '当你选择该窗体时，即会在最顶端'
        ,area: ['400px', '800px']
        ,shade: 0
        ,id: 'login' //设定一个id，防止重复弹出
        ,move: false
        ,content: 'http://layer.layui.com/test/settop.html'
        ,btn: ['登录', '取消']
        ,yes: function(){
          $(that).click();
        }
        ,btn2: function(){
          layer.closeAll();
        }
        
        ,zIndex: layer.zIndex //重点1
        ,success: function(layero){
          layer.setTop(layero); //重点2
        }
      });
    }


    ,notice: function(){
      //示范一个公告层
      layer.open({
        type: 1     //改成2
        ,title: '登录'
        ,area: ['450px', '300px']
        ,shade: 0
        ,id: 'login'
        ,btn: ['登录', '关闭']
        ,move: false
        ,content: 'testtesttesttesttesttesttest'
        ,success: function(layero){
          var btn = layero.find('.layui-layer-btn');
          // btn.css('text-align', 'center');
          btn.find('.layui-layer-btn0').attr({
            href: '../../学生事务管理系统/system/success.html'
            ,target: '_blank'
          });
        }
      });
    }
  };
  $('.site-demo-layer').on('click', function(){
    var type = $(this).data('type');
    active[type] ? active[type].call(this) : '';
  });
});