// Nice little function borrowed from: http://tetlaw.id.au/view/blog/dateprototypeadjust/
Date.prototype.adjust = function(yr,mn,dy,hr,mi,se) {
  var m,t;
  this.setYear(this.getFullYear() + yr);
  m = this.getMonth() + mn;
  if(m != 0) this.setYear(this.getFullYear() + Math.floor(m/12));
  if(m < 0) {
    this.setMonth(12 + (m%12));
  }
  else if(m > 0) {
    this.setMonth(m%12);
  }
  t = this.getTime();
  t += (dy * 86400000);
  t += (hr * 3600000);
  t += (mi * 60000);
  t += (se * 1000);
  this.setTime(t);
  return this;
}

jQuery(document).ready(function() {
  jQuery('#timeline-left-arrow').click(function() {
    var band = tl.getBand(0);
    var d = band.getCenterVisibleDate();
    band.setCenterVisibleDate(d.adjust(0,-8,0,0,0,0)); 
  });

  jQuery('#timeline-right-arrow').click(function() {
    var band = tl.getBand(0);
    var d = band.getCenterVisibleDate();
    band.setCenterVisibleDate(d.adjust(0,8,0,0,0,0)); 
  });
});


Timeline.DefaultEventSource.Event.prototype = {
    getID:          function() { return this._id; },
    
    isInstant:      function() { return this._instant; },
    isImprecise:    function() { return this._start != this._latestStart || this._end != this._earliestEnd; },
    
    getStart:       function() { return this._start; },
    getEnd:         function() { return this._end; },
    getLatestStart: function() { return this._latestStart; },
    getEarliestEnd: function() { return this._earliestEnd; },
    
    getEventID:     function() { return this._eventID; },
    getText:        function() { return this._text; }, // title
    getDescription: function() { return this._description; },
    getImage:       function() { return this._image; },
    getLink:        function() { return this._link; },
    
    getIcon:        function() { return this._icon; },
    getColor:       function() { return this._color; },
    getTextColor:   function() { return this._textColor; },
    getClassName:   function() { return this._classname; },
    getTapeImage:   function() { return this._tapeImage; },
    getTapeRepeat:  function() { return this._tapeRepeat; },
    getTrackNum:    function() { return this._trackNum; },
    
    getProperty:    function(name) { return null; },
    
    getWikiURL:     function() { return this._wikiURL; },
    getWikiSection: function() { return this._wikiSection; },
    setWikiInfo: function(wikiURL, wikiSection) {
        this._wikiURL = wikiURL;
        this._wikiSection = wikiSection;
    },
    
    fillDescription: function(elmt) {
        elmt.innerHTML = this._description;
    },
    fillWikiInfo: function(elmt) {
        // Many bubbles will not support a wiki link. 
        // 
        // Strategy: assume no wiki link. If we do have
        // enough parameters for one, then create it.
        elmt.style.display = "none"; // default
        
        if (this._wikiURL == null || this._wikiSection == null) {
          return; // EARLY RETURN
        }

        // create the wikiID from the property or from the event text (the title)      
        var wikiID = this.getProperty("wikiID");
        if (wikiID == null || wikiID.length == 0) {
            wikiID = this.getText(); // use the title as the backup wiki id
        }
        
        if (wikiID == null || wikiID.length == 0) {
          return; // No wikiID. Thus EARLY RETURN
        }
          
        // ready to go...
        elmt.style.display = "inline";
        wikiID = wikiID.replace(/\s/g, "_");
        var url = this._wikiURL + this._wikiSection.replace(/\s/g, "_") + "/" + wikiID;
        var a = document.createElement("a");
        a.href = url;
        a.target = "new";
        a.innerHTML = Timeline.strings[Timeline.clientLocale].wikiLinkLabel;
        
        elmt.appendChild(document.createTextNode("["));
        elmt.appendChild(a);
        elmt.appendChild(document.createTextNode("]"));
    },
    
    fillTime: function(elmt, labeller) {
        if (this._instant) {
            if (this.isImprecise()) {
                elmt.appendChild(elmt.ownerDocument.createTextNode(labeller.labelPrecise(this._start)));
                elmt.appendChild(elmt.ownerDocument.createElement("br"));
                elmt.appendChild(elmt.ownerDocument.createTextNode(labeller.labelPrecise(this._end)));
            } else {
                elmt.appendChild(elmt.ownerDocument.createTextNode(labeller.labelPrecise(this._start)));
            }
        } else {
            if (this.isImprecise()) {
                elmt.appendChild(elmt.ownerDocument.createTextNode(
                    labeller.labelPrecise(this._start) + " ~ " + labeller.labelPrecise(this._latestStart)));
                elmt.appendChild(elmt.ownerDocument.createElement("br"));
                elmt.appendChild(elmt.ownerDocument.createTextNode(
                    labeller.labelPrecise(this._earliestEnd) + " ~ " + labeller.labelPrecise(this._end)));
            } else {
                elmt.appendChild(elmt.ownerDocument.createTextNode(labeller.labelPrecise(this._start)));
                elmt.appendChild(elmt.ownerDocument.createElement("br"));
                elmt.appendChild(elmt.ownerDocument.createTextNode(labeller.labelPrecise(this._end)));
            }
        }
    },
    
    fillInfoBubble: function(elmt, theme, labeller) {
        var doc = elmt.ownerDocument;
        
        var title = this.getText();
        var link = this.getLink();
        var image = this.getImage();
        
        if (image != null) {
            var img = doc.createElement("img");
            img.src = image;
            
            theme.event.bubble.imageStyler(img);
            elmt.appendChild(img);
        }
        
        title = title.replace(/&#039;/g, "'");

        var divTitle = doc.createElement("div");
        var textTitle = doc.createTextNode(title);

        divTitle.appendChild(textTitle);
        theme.event.bubble.titleStyler(divTitle);
        elmt.appendChild(divTitle);
        
        var divBody = doc.createElement("div");
        this.fillDescription(divBody);
        theme.event.bubble.bodyStyler(divBody);
        elmt.appendChild(divBody);
        
        var divTime = doc.createElement("div");
        this.fillTime(divTime, labeller);
        theme.event.bubble.timeStyler(divTime);
        elmt.appendChild(divTime);
        
        var divWiki = doc.createElement("div");
        this.fillWikiInfo(divWiki);
        theme.event.bubble.wikiStyler(divWiki);
        elmt.appendChild(divWiki);
    }
};
