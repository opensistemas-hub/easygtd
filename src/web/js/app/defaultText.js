function defaultText() {

jq(".defaultText").focus(function(srcc)
    {
        if (jq(this).val() == jq(this)[0].title)
        {
            jq(this).removeClass("defaultTextActive");
            jq(this).val("");
        }
    });
    
    jq(".defaultText").blur(function()
    {
        if (jq(this).val() == "")
        {
            jq(this).addClass("defaultTextActive");
            jq(this).val(jq(this)[0].title);
        }
    });
    
    jq(".defaultText").blur();        


}
