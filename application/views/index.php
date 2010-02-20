<div id="header">
	<h1>Jelly.</h1>
	<h2>An Open Source <a href="http://en.wikipedia.org/wiki/Object_Relational_Mapping">Object Relational Mapping</a> library for <a href="http://www.kohanaphp.com">Kohana 3</a></h2>
	<img src="images/jelly-large.png" alt="Large Jelly Icon" />
</div>

<div id="features">
	<p>Jelly is a compact but powerful ORM library. It’s currently in beta however it is 
	<a href="http://github.com/jonathangeiger/jelly-tests">unit tested</a> and <a href="<?php echo URL::site('docs') ?>">well documented</a>.</p>
	<h3>Notable Features</h3>
	<ul>
		<li>
			<strong>Relatively small, clean, well-commented codebase</strong>
			<p>Compared with other libraries with similar feature sets, Jelly is relatively light-weight yet powerfully extenisble.</p>
		</li>
		<li>
			<strong>Top-to-bottom table column aliasing</strong>
			<p>All references to database columns and tables are made via their aliased names and converted transparently, on the fly.</p>
		</li>
		<li>
			<strong>A built-in query builder</strong>
			<p>This features is a near direct port from Kohana's native ORM.</p>
		</li>
		<li>
			<strong>Extensible field architecture</strong>
			<p>All fields in a model are represented by a <code>Field_*</code> class, which can implement ready-made behaviors or be extended 
			to provide huge flexibility without changes to the core library.</p>
		</li>
		<li>
			<strong>No circular references</strong>
			<p>Fields are well-designed to prevent the infinite loop problems. 
			It's even possible to have same-table child/parent references out of the box.</p>
		</li>
	</ul>
</div>

<div id="right-col">
	<div id="download">
		<a href="http://github.com/jonathangeiger/kohana-jelly/downloads">
			<img src="/images/download.png" alt="Download" />
		</a>
		<h3><a href="http://github.com/jonathangeiger/kohana-jelly/downloads">Download</a></h3>
		<span>Get Jelly from github</span>
	</div>
	<div id="documentation">
		<a href="<?php echo URL::site('docs') ?>">
			<img src="/images/docs.png" alt="Documentation" />
		</a>
		<h3><a href="<?php echo URL::site('docs') ?>">Documentation</a></h3>
		<span>Userguide and API reference</span>
	</div>
</div>

<div id="footer">
	Jelly is &copy copyright Jonathan Geiger 2010<?php echo date('Y') > 2010 ? ' - '.date('Y') : '' ?> and released under an <a href="http://www.opensource.org/licenses/mit-license.php">MIT</a> license
</div>
