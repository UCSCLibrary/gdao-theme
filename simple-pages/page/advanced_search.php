<form id="advanced-search-form" action="/solr-search/results/index?" method="get">
  <div id="search-keywords" class="field">
    <span class="as-label">Search </span>
    <div class="as-field as-query">
      <select name="as-1">
        <option value="">Keyword</option>
        <option value="c">Creator</option>
        <option value="t">Title</option>
        <option value="s">Subject</option>
      </select> for <input type="text" name="as-val-1" value="" />
    </div>
    <div class="as-field as-query">
      <select name="as-2">
        <option value="">Keyword</option>
        <option value="c">Creator</option>
        <option value="t">Title</option>
        <option value="s">Subject</option>
      </select> for <input type="text" name="as-2-val" value="" />
    </div>
    <div class="as-field as-query">
      <select name="as-3">
        <option value="">Keyword</option>
        <option value="c">Creator</option>
        <option value="t">Title</option>
        <option value="s">Subject</option>
      </select> for <input type="text" name="as-3-val" value="" />
    </div>
<!--     
    <div class="as-field" id="date-limit">
      <span class="as-label">Limit your search by date: </span>
      <p>From <input type="text" id="datepicker1"/> to <input type="text" id="datepicker2"/></p>
    </div>
-->
    <div class="as-field" id="type-limit">
      <span class="as-label">Limit your search by item format: </span>
      <p>
        <select name="itemtype" id="item-type">
          <option value="">Select one</option>
          <option value="Album Cover">Album Cover</option>
          <option value="Article">Article</option>
          <option value="Backstage Pass">Backstage Pass</option>
          <option value="Envelope">Envelope</option>
          <option value="Fan Art">Fan Art</option>
          <option value="Fan Tape">Fan Tape</option>
          <option value="Fanzine">Fanzine</option>
          <option value="Image"">Image</option>
          <option value="Laminate">Laminate</option>
          <option value="Newsletter">Newsletter</option>
          <option value="Notebook">Notebook</option>
          <option value="Poster">Poster</option>
          <option value="Program">Program</option>
          <option value="Story">Story</option>
          <option value="T-Shirt">T-Shirt</option>
          <option value="Ticket">Ticket</option>
          <option value="Sound">Sound</option>
          <option value="Video">Video</option>
          <option value="Website">Website</option>
        </select>
      </p>
    </div>
    <div class="as-field">
      <input type="submit" id="as-submit" value="Submit" />
    </div>
  </div>
</form>
