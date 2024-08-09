<?php
if (!defined('DOKU_INC')) die('must be run from within DokuWiki');
@require_once dirname(__FILE__) . '/tpl_functions.php';

$pagetoolsloc=tpl_getConf('pagetoolsloc');
$pagetoolsshowtitle=tpl_getConf('pagetoolsshowtitle');



$showTools = !tpl_getConf('hideTools') || (tpl_getConf('hideTools') && !empty($_SERVER['REMOTE_USER']));
$showSidebar = page_findnearest($conf['sidebar']) && ($ACT == 'show');
$showIcon = tpl_getConf('showIcon');
?>
<!DOCTYPE html>
<html lang="<?php echo $conf['lang'] ?>" dir="<?php echo $lang['direction'] ?>">
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
		<link rel="icon" type="image/png" href="assets/img/favicon.png">
			<?php 
		echo "<title>";
		echo tpl_pagetitle().' ['.strip_tags($conf['title']).']';
    echo "</title>\n";
		tpl_metaheaders();
		echo tpl_favicon(['favicon',	'mobile']);
		tpl_includeFile('meta.html');
		?>
	</head>

	<body class="docs ">
		<div id="dokuwiki__site">
		<?php
			ob_start(); tpl_content(false);	$pagecontent = ob_get_clean();

			//======= HANDLE notitle parameter =======
			if(tpl_getConf('handlenotitle')&&isset($_REQUEST['notitle'])&&(empty($_REQUEST['title'])||$_REQUEST['title'])){
				preg_match('#<(h\d+)\b#',$pagecontent,$m,PREG_OFFSET_CAPTURE);
				if($m){
					$firsthpos=$m[0][1];
					preg_match('#<(div|p|ul|pre|table)\b#',$pagecontent,$m,PREG_OFFSET_CAPTURE);
					if(!$m||$m[0][1]>$firsthpos){
						$pagecontent=preg_replace('#<(h\d+)\b[^>]*>(.*)</\1>#','',$pagecontent,1);
					} 
				}
			}
			//======= HANDLE printview parameter =======
			if(tpl_getConf('handleprintview')&&isset($_REQUEST['printview'])&&(empty($_REQUEST['printview'])||$_REQUEST['printview'])){
				#this is a quick hack to modify links to persist printview=1 parameter.
				if(tpl_getConf('handleprintview_alterlinks'))	$pagecontent=preg_replace('#(<a href=")([^"]+\?id=[^"]+)("[^<]* class="wikilink2"[^<]*>)#','$1$2&printview=1$3',$pagecontent);
				html_msgarea();
				echo $pagecontent;
				echo "</body></html>";
				exit;
			}
		?>
			<header
				class="navbar navbar-horizontal navbar-expand navbar-dark flex-row align-items-md-center ct-navbar bg-primary py-2">

				
				<?php
				echo "<div class='header-title'>\n";
				if(tpl_getConf('navbar_showlogo')){
					tpl_showlogo();
				}
				if(!tpl_getConf('navbar_titleasbutton')){
					tpl_link(wl(), $conf['title'], 'accesskey="h" title="[H]"');
				}
				echo "</div>\n";
				if(tpl_getConf('navbar_titleasbutton')){
						echo "<div class='btn btn-neutral btn-icon'>\n"
									."<span class='btn-inner--icon'><!-- <i class=''></i> --></span>\n"
									." <span class='nav-link-inner--text'>\n";
							tpl_link(wl(), $conf['title'], 'accesskey="h" title="[H]"');
							echo "\n</span>\n</div>\n";
					}
				?>

				<div class="d-none d-sm-block ml-auto">
					<ul class="navbar-nav ct-navbar-nav flex-row align-items-center">
					<?php
					tpl_showsection('navbar');
					?>
					</ul>
				</div>
				<button class="navbar-toggler ct-search-docs-toggle d-block d-md-none ml-auto ml-sm-0" type="button"
					data-toggle="collapse" data-target="#ct-docs-nav" aria-controls="ct-docs-nav" aria-expanded="false"
					aria-label="Toggle docs navigation">
					<span class="navbar-toggler-icon"></span>
				</button>

			</header>



			<div class="container-fluid">
				<div class="row flex-xl-nowrap">

					<!-- left sidebar -->
					<div class="col-12 col-md-3 col-xl-2 ct-sidebar"><nav class="collapse ct-links" id="ct-docs-nav">
						<?php	tpl_showsection('sidebar');	?>
					</nav></div>


					<!-- center content -->
					<main class="col-12 col-md-9 col-xl-8 py-md-3 pl-md-5 ct-content dokuwiki" role="main">

					<div id="dokuwiki__top" class="site
						<?php echo tpl_classes();
							if(tpl_getConf('showsidebar')) echo 'hasSidebar';
						?>
						"></div>

						<?php tpl_showsection('contenttop'); ?>


						<!-- Wiki Contents -->
						<div id="dokuwiki__content">
							<div class="pad">

								<div class="page">

									<?php echo $pagecontent; ?>
								</div>
							</div>							
						</div>

						<hr />
						<!-- Footer -->
						<div id="dokuwiki__footer">
							<?php tpl_showsection('footer'); ?>
						</div>
						<?php tpl_indexerWebBug(); ?>
					</main>




					<!-- Right Sidebar -->
					<div class="d-none d-xl-block col-xl-2 ct-toc">
						<div>
							<?php tpl_toc()?>
						</div>
					</div>

				</div>
			</div>
		</div>
	</body>

</html>
