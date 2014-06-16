$(function(){
    // 新闻列表api
    var api_latest = '/news/latest';
    var api_before = '/news/before';

    // 预加载
    $.getJSON(api_latest, function(result) {
        $('#news').attr('curdate', get_cur_date()); // 设置当前日期
        show_display_date(1, result.data.display_date);// 展示当前日期
        $.each(result.data.news, function(index, value) {
            show_news(value.title, value.thumbnail, value.id); // 展示新闻列表
        });
        $(window).trigger('scroll');
    });

    // 自动加载
	var hasLoad = 0;
    $(window).scroll(function() {
        if ($(document).scrollTop() >= $(document).height() - $(window).height() - 100) {
			if (1 == hasLoad) return false;
            $('#loading').show(); // 显示正在加载图片
            var curdate = $('#news').attr('curdate');
            var api = api_before + '/date/' + curdate;
            $.ajax({
                url: api,
                async: true,
                dataType: 'json',
                success: function(result) {
                    $('#loading').hide(); // 隐藏图片
                    show_display_date(0, result.data.display_date);// 展示当前日期
                    $('#news').attr('curdate', parseInt(curdate)-1); // 设置当前日期-1天
                    $.each(result.data.news, function(index, value) {
                        show_news(value.title, value.thumbnail, value.id);
                    });
					hasLoad = 0;
                },
				beforeSend : function(result) {
					hasLoad = 1;
				},
            });
        }
    });
})
function get_cur_date() {
    var myDate = new Date();
    var year = myDate.getFullYear();
    var month = myDate.getMonth();
    var date = myDate.getDate();
    if (month <= 9) {
        month =  month + 1;
        month = '0' + month;
    }
    if (date <= 9) {
        date = '0' + date;
    }
    return year + month + date;
}
function show_display_date(is_today, datestr) {
    var html = '';
    if (1 == is_today) {
        html += '<h3>';
        html += '<span class="tips">今日热闻</span>';
        html += '<span class="tips-date">'+datestr+'</span>';
        html += '</h3>';
    } else {
        html += '<h3>';
        html += '<span class="tips-date">'+datestr+'</span>';
        html += '</h3>';
    }
    $('#news').append(html);
}
function show_news(title, thumb, id) {
    var html = '<a href="http://daily.zhihu.com/story/'+id+'">';
    html += '<div><img src="'+thumb+'"/></div>';
    html += '<span>'+title+'</span>';
    html += '</a>';
    $('#news').append(html);
}
