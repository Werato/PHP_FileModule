function Files()
{
    this.afterLoad = {
        
        getContentFromFrame: function(target) {
            var linkedFrame = document.getElementById('hiddenframe'),
            content = linkedFrame.contentWindow.document.body.innerHTML;
            target[target.length-1].innerHTML = content;        
        },

        cloneElement: function(target)
        {
            target[target.length-1].outerHTML += "<div class=\"unloadImg\"></div>";   
        }

    }
}

file = new Files();