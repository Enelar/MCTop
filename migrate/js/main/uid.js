function store_uid(data)
{
    var t = data.uid;
    window.uid = function()
    {
        return t;
    };
}

