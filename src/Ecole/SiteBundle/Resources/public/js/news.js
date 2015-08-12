jQuery.fn.newsTicker = jQuery.fn.newsticker = function(delay)
{
        return this.each(
                function()
                {
                        if(this.nodeName.toLowerCase()!= "ul") return;
                        delay = delay || 4000;
                        var self = this;
                        self.items = jQuery("li", self);
                        // hide all items (except first one)
                        self.items.not(":eq(0)").hide().end();
                        // current item
                        self.currentitem = 0;
                        var doTick = function()
                        {
                                jQuery.newsticker(self);
                        }
                        setInterval(doTick,delay);
                }
        )
        .addClass("newsticker")
        .hover(
                function()
                {
                        // pause if hovered over
                        this.pause = true;
                },
                function()
                {
                        // unpause when not hovered over
                        this.pause = false;
                }
        );
}
jQuery.newsticker = function(el)
{
        // return if hovered over
        if(el.pause) return;
        // hide current item
        jQuery(el.items[el.currentitem]).fadeOut("slow",
                function()
                {
                        jQuery(this).hide();
                        // move to next item and show
                        el.currentitem = ++el.currentitem % (el.items.size());
                        jQuery(el.items[el.currentitem]).fadeIn("slow");
                }
        );
}

$(document).ready(
        function()
        {
                $("#news").newsTicker();
        }
);
