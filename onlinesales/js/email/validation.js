Validation.addAllThese([  
  
    ['validate-cemail', 'Please make sure your emails match.', function(v) {  
                var conf = $('email2') ? $('email2') : $$('.validate-cemail')[0];  
                var pass = false;  
				var confirm;  
                if ($('email_address')) {  
                    pass = $('email_address');  
                } 
				
				confirm =conf.value;  
												
				if(!confirm && $('email2'))  
				  {  
				  confirm = $('email2').value;  
				  }  
				return (pass.value == confirm);  
            }],  
]);   