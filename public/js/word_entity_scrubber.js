/**
 * MIT License
 *
 * Copyright (c) 2004 Tim Jarrett
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */

var Word_Entity_Scrubber = function()
{
	/**
	 * The DOM element to get the input from
	 *
	 * @access protected
	 */
	this.elem_input = null;
	
	/**
	 * The DOM element to get the output from
	 *
	 * @access protected
	 */
	this.elem_output = null;
	
	/**
	 * The array of MS Word characters to find for replacement
	 *
	 * @access protected
	 */
	this.arr_find = [
		String.fromCharCode(8220),
		String.fromCharCode(8221),
		String.fromCharCode(8216),
		String.fromCharCode(8217),
		String.fromCharCode(8211),
		String.fromCharCode(8212),
		String.fromCharCode(189),
		String.fromCharCode(188),
		String.fromCharCode(190),
		String.fromCharCode(169),
		String.fromCharCode(174),
		String.fromCharCode(8230)
	];
	
	/**
	 * The array of standard string to replace MS Word characters in this.arr_find with
	 *
	 * @access protected
	 */
	this.arr_replace = [
		'"',
		'"',
		"'",
		"'",
		"-",
		"--",
		"1/2",
		"1/4",
		"3/4",
		"(C)",
		"(R)",
		"..."
	];
	
	/**
	 * Method for binding the scrubbing function to DOM elements
	 *
	 * @access public
	 * @param elem_input- The element (or string id of the element) whose "value" property you want to filter
	 * @param elem_output- The element (or string id of the element) whose "value" property should get the filtered output
	 * @param elem_activate- The element (or string id of the element) acted upon (such as button) to fire the scrubbing action
	 * @param elem_activate_action		- The action on elem_activate to listen to (such as "onclick")
	 * @return void
	 */
	this.bindTo = function(elem_input, elem_output, elem_activate, elem_activate_action)
	{
		//Store the input element
		this.elem_input = $(elem_input);
		
		//Store the output element
		this.elem_output = $(elem_output);
		
		//Just to be sure we've got the DOM element
		elem_activate = $(elem_activate);
		
		//Assign the appropriate action to the activate element
		elem_activate[elem_activate_action] = this.bindScrub.bind(this);
		
	}//end bindTo
	
	/**
	 * Just a method to facilitate with bindTo
	 *
	 * @access public
	 * @return void
	 */
	this.bindScrub = function()
	{
		this.elem_output.value = this.scrub(this.elem_input.value);
		
	}//end bindScrub
	
	/**
	 * This is where the magic happens.  Give it a string and it will output 
	 * the scrubbed string.  You can call statically from Word_Entity_Scrubber.scrub()
	 *
	 * @access public
	 * @param input_string		- The string to be scrubbed
	 * @return string
	 */
	this.scrub = function(input_string)
	{		
		//Make sure find and replace have equal lengths
		if ( !(this.arr_find.length == this.arr_replace.length) ) {
			throw new Error("The MS Word entities find values do not match the replacement values");
			
		}
		
		//Still here, then replacement rules are ok - loop across and do the replacement
		for ( var i=0; i<this.arr_find.length; i++ ) {
			var regex = new RegExp(this.arr_find[i], "gi");
			input_string = input_string.replace(regex, this.arr_replace[i]);
			
		}//for
		
		//Put the cleaned string into the output box
		return input_string
		
	}//end scrub
	
}//end Word_Entity_Scrubber

/**
 * Just a little bit of a hack to get Word_Entity_Scrubber.scrub() to work as a 
 * "static" method as well as a method on an instance object...
 */
Word_Entity_Scrubber.scrub = function(input_string)
{
	var obj = new Word_Entity_Scrubber();
	return obj.scrub(input_string);
	
}//end Word_Entity_Scrubber.scrub
