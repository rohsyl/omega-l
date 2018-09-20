<p>Parameters:
</p>
<table class="table">
    <tr>
        <th>Multiple</th>
        <td>true, false</td>
        <td>Allow selection of more than one file</td>
    </tr>
    <tr>
        <th>Preview</th>
        <td>true, false</td>
        <td>Display a preview of the file or not</td>
    </tr>
    <tr>
        <th>Type</th>
        <td>picture, video, video_ext, audio, document, folder</td>
        <td>Allow only selected type</td>
    </tr>
</table>
<pre>
{
   "multiple":false,
   "preview":true,
   "type":[
      "picture", "video"
   ]
}
</pre>
<p>Exemple of SQL insert with MediaChooser type:</p>
<pre>
CALL `om_CreateFormEntry`('[form_name]', '[field_name]', 1, 'Omega\\Library\\Plugin\\Type\\MediaChooser', '[param]', '[field_title]', '[field_description]', 0);
</pre>