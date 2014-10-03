var patch_jquery_form = function()
{
    patch_jquery_form.wait_for();
}

patch_jquery_form.wait_for = function()
{
    if (typeof $.fn.ajaxForm != 'function')
        return phoxy.Defer(arguments.callee, 100);
    patch_jquery_form.do_patch();
}

patch_jquery_form.do_patch = function()
{
    var origin_form = $.fn.ajaxForm;
    var generate_cb = patch_jquery_form.gen_submit_callback;

    $.fn.ajaxForm = function(obj)
    {
        obj = obj || {};
        if (typeof obj == 'function')
            obj = {success: obj};

        url = obj.url || this.attr('action')
        obj.url = phoxy.Config()['api_dir'] + url;

        if (!obj.raw)
        {
            if (typeof obj.success == 'function')
                obj.success = generate_cb(obj.success);
            if (typeof obj.dataType == 'undefined')
                obj.dataType = 'json';
        }

        origin_form.call(this, obj);
    }

    //var origin_submit =  $.fn.ajaxSubmit;

    //$.fn.ajaxSubmit = function()
    //{
    //    alert("TODO: patch form submit")
    //}
}

patch_jquery_form.gen_phoxy_submit_callback = function(cb)
{
    return function(responce)
    {
        return phoxy.ApiAnswer(responce, function()
        {
            cb(responce);
        });
    }
}

patch_jquery_form.gen_submit_callback = function(cb)
{
    return patch_jquery_form.gen_phoxy_submit_callback(function(responce)
    {
        return cb(responce.data);
    })
}

patch_jquery_form();