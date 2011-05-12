Pharao
---------------

The PHP functionality for archiving projects offers a great way to de-clutter and speed up your distributable. It doesn't however make it easy to integrate it into a development workflow.

Pharao is a very light tool to help integrate Phar archiving for distributables into your development workflow. The source code is still very experimental and not to be critiqued too strongly just yet.

Pharoa lets you select a folder from your project and turn it into a php Phar tarZipped archive that is useable on it's own or can be used in an integrated fashion in your project development flow.

**Pharao::setDevelop(true)**
This will automatically compile all folders added via Pharao. To be used in development environment where changes to your files are automatically injected into your Phar archives. This option significantly slows down your application as it requires re-creating the Phar archives every time a page is accessed.

**Pharao::addPhar(archive_name,folder)**
This command will add an archive to Pharao's registry. This is used both in the compilation phase and also in the generation of uri's for including phar-archived files into your project.

**Pharao::getUri(archive-name,file-path)**
This function will return the phar:// uri you can use to include a file from your archive into your project. *eg: require_once(Pharao::getUri(archive-name,archive-file-path));*

**Pharao::setBaseFolder('phar-archive-folder')**
This you can use to specify the output folder for phar archives. This is also used in the generation of uri's for those archives and their members.