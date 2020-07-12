// JavaScript Document

//main navigation for IE
var startList;

startList = function() 
{
	if (document.all&&document.getElementById && (navigator.appName != "Opera") && (typeof window.opera == "undefined")) 
	{
		navRoot = document.getElementById("navi");
		for (i=0; i<navRoot.childNodes.length; i++) 
		{
			node = navRoot.childNodes[i];
			if (node.nodeName=="TD") 
			{
				node.onmouseover=function() 
				{
					this.className="over";
					for(sl=0;sl<document.getElementsByTagName("select").length;sl++)
					{
						document.getElementsByTagName("select")[sl].style.visibility = "hidden"
					}
			  	}
			  	
				node.onmouseout=function() 
				{
			  		this.className=this.className.replace("over", "");
					for(sl=0;sl<document.getElementsByTagName("select").length;sl++)
					{
						document.getElementsByTagName("select")[sl].style.visibility = "visible"
					}
			   	}
			}
		}
	}
}

//window.onload=startList;