## IDE

.PHONY: ide.phpstorm.templates
ide.phpstorm.templates: .idea ## PHPStorm: Copy all templates of project in fileTemplates folder of PHPStorm. | https://www.jetbrains.com/help/phpstorm/using-file-and-code-templates.html
	cp -R .ide/PHPStorm/fileTemplates/. .idea/fileTemplates/