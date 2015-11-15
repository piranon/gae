CKEDITOR.plugins.add( 'imagegallery',
{
	init: function( editor )
	{
		editor.addCommand( 'imagegallery', new CKEDITOR.command( editor, {
		    exec: function( editor ) {
		        //console.log("CKEDITOR.command" );
		        if(editor.imagegalleryButtonOnClick){
		        	editor.imagegalleryButtonOnClick(editor);
		        }
		    }
		}));
		editor.ui.addButton( 'imagegallery',
		{
			label: 'Open ImageGallery',
			command: 'imagegallery',
			icon: this.path + 'images/icon.png'
		});
	}
} );