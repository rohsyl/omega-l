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
<p>Exemple :</p>
<pre>
&lt;?php
	FormFactory::newFormEntry('[form_name]', '[entry_name]', [order], Omega\Utils\Plugin\Type\MediaChooser::class, [param], '[title]', '[description]', '[mandatory]')
?&gt;
</pre>