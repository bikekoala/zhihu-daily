$(function(){
    // 新闻列表api
    var api_latest = '/?c=news&a=latest';
    var api_before = '/?c=news&a=before';

    // 预加载
    $.getJSON(api_latest, function(result) {
        $('#news').attr('curdate', result.data.date); // 设置当前日期
        show_display_date(1, result.data.date);// 展示当前日期
        $.each(result.data.stories, function(index, value) {
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
            var api = api_before + '&date=' + curdate;
            $.ajax({
                url: api,
                async: true,
                dataType: 'json',
                success: function(result) {
                    $('#loading').hide(); // 隐藏图片
                    show_display_date(0, result.data.date);// 展示当前日期
                    $('#news').attr('curdate', parseInt(curdate)-1); // 设置当前日期-1天
                    $.each(result.data.stories, function(index, value) {
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

function get_date_str(date_num, need_week) {
    var date_arr = date_num.match(/^ *(\d{4})(\d{1,2})(\d{1,2}) *$/);  
    var date = new Date(parseInt(date_arr[1]), parseInt(date_arr[2]) -1, (date_arr[3]));
    var date_str = date.getFullYear() + '.' + date.getMonth() + 1 + '.' + date.getDate();

    if (need_week) {
        date_str += ' 星期' + ['日', '一', '二', '三', '四', '五', '六'][date.getDay()];
    }

    return date_str;
}

function show_display_date(is_today, date_num) {
    var html = '';

    if (1 == is_today) {
        html += '<h3>';
        html += '<span class="tips">今日热闻</span>';
        html += '<span class="tips-date">' + get_date_str(date_num, 1) + '</span>';
        html += '</h3>';
    } else {
        html += '<h3>';
        html += '<span class="tips-date">' + get_date_str(date_num) + '</span>';
        html += '</h3>';
    }
    $('#news').append(html);
}

function show_news(title, image, id) {
    var html = '<a href="http://daily.zhihu.com/story/'+id+'">';
    html += '<div><img src="'+image+'"/></div>';
    html += '<span>'+title+'</span>';
    html += '</a>';
    $('#news').append(html);
}
