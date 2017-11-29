<?php 
require_once("core/php/functions/commonFunctions.php");
$baseUrl = "core/";
if(file_exists('local/layout.php'))
{
	$baseUrl = "local/";
	//there is custom information, use this
	require_once('local/layout.php');
	$baseUrl .= $currentSelectedTheme."/";
}
require_once($baseUrl.'conf/config.php'); 
require_once('core/conf/config.php');
require_once('core/php/configStatic.php');  
require_once('core/php/update/updateCheck.php');

#tmpvars
$ldapCacheType = 'none';

require_once('core/php/loadVars.php'); ?>
<!doctype html>
<head>
	<title>Git Status | Settings</title>
	<link rel="stylesheet" type="text/css" href="<?php echo $baseUrl ?>template/theme.css">
	<link rel="icon" type="image/png" href="core/img/favicon.png" />
</head>
<body>
	
	<?php require_once('core/php/templateFiles/sidebar.php'); ?>
	<?php require_once('core/php/templateFiles/header.php'); ?>
	<div id="main">
	<?php if($loginAuthType == 'LDAP'): ?>
		<div class="firstBoxDev">
			<div class="innerFirstDevBox"  >
				<div class="devBoxTitle">
					<b>General LDAP Settings</b> 
				</div>
				<div class="devBoxContent">
					<ul class="settingsUl">
						<li>
							<span>Default Domain</span>
							<input type="text" name="LPADdefaultDomain" value="example.com">
						</li>
						<li>
							<span class="leftSpacingserverNames" >Cache Type</span>
							<select name="ldapCacheType">
	  						<option <?php if($ldapCacheType == 'stash'){echo "selected";} ?> value="disabled">stash</option>
	  						<option <?php if($ldapCacheType == 'doctrine'){echo "selected";} ?> value="doctrine">doctrine</option>
	  						<option <?php if($ldapCacheType == 'none'){echo "selected";} ?> value="none">none</option>
						</select>
						</li>
						<li>
							<a class="buttonButton">Clear LDAP</a>
						</li>
						<?php 
						# Optional: When using the LdapManager and there are multiple domains configured, the following domain
					    #   will be selected first by default for any operations.
					    ## default_domain: "example.com"
					    # Optional: The format that the schema is in. Default: yml
					    ## schema_format: yml
					    # Optional: The location to use when loading schema files. Default: "resources/schema" in the library
					    #   root.
					    ## schema_folder: "/var/www/project/resources/schema"
					    # The cache type to use. Either 'stash', 'doctrine', or 'none'. Default: none
					    ## cache_type: none
					    # Optional: These are variable settings for the cache type in use.
					    ## cache_options:
					        # Type: stash, doctrine
					        # Optional: The location to cache generated schema data. Default: The systems temporary directory.
					        ## cache_folder: "/tmp/projectCache"
					        # Type: stash
					        # Optional: Whether the cache should auto-refresh based on mod times. This is enabled by default with stash.
					        #  However, the doctrine type does not support it.
					        ## cache_auto_refresh: false
						?>
					</ul>
				</div>
				<span id="newDomainLDAPLOcation" ></span>
				<?php
				# At least one domain is required.
				  ##  example:
				        # Required: The full domain name.
				        ##domain_name: "example.com"
				        # Required: The user to use for binding to LDAP and subsequent operations for the connection.
				        ##username: user
				        # Required: The password for the user binding to LDAP.
				        ##password: 12345
				        # Recommended: The base DN (default naming context) for the domain. If this is empty then it will be queried
				        #   from the RootDSE.
				        ##base_dn: "dc=example,dc=com"
				        # Recommended: One or more LDAP servers to connect to. If this is empty then it will query DNS for a
				        #   list of LDAP servers for the domain.
				        ##servers: [ 'example1','example2' ]
				        # Optional: Whether or not paging should be used for query operations. Default: true
				        ##use_paging: true
				        # Optional: The page size to use for paging operations, such as searches. Default: 1000
				        ##page_size: 1000
				        # Optional: The port to communicate to the LDAP servers on. If this is not set, the default is 389.
				        #   If this is not set and 'use_ssl' is specified, the the port will be set to 636.
				        ##port: 389
				        # Optional: Whether or not to talk to LDAP over SSL. Default: false
				        ##use_ssl: false
				        # Optional: Whether or not to talk to LDAP over TLS. Default: false
				        # If this is set to false, certain operations will not work. Such as password changes.
				        ##use_tls: false
				        # Optional: The LDAP type for this domain: ad, openldap. Default: ad
				        ##ldap_type: openldap
				        # Optional: Whether the connection should wait to bind until necessary (true) or bind immediately
				        #   on construction (false). Default: false
				        ##lazy_bind: false
				        # Optional: When more than one server is listed for a domain, choose which one is selected for the
				        #   connection. The possible choices are: order (tried in the order they appear), random. Default: order
				        ##server_selection: order
				        # Optional: The encoding type to use. Default: UTF-8
				        ##encoding: UTF-8
				        # Optional: The format that the username should be in when binding. This allows for two possible
				        #   placeholders: %username% and %domainname%. The domain name parameter is the FQDN. Default: For AD
				        #   the default is "%username%@%domainname%", for OpenLDAP it is simply "%username%". But you could easily
				        #   make it something like "CN=%username%,OU=Users,DC=example,DC=local".
				        ##bind_format: "%username%"
				        # Optional: The LDAP_OPT_* constants to use when connecting to LDAP. Default: Sets the protocol version to 3 and
				        #   disables referrals.
				        ##ldap_options:
				        ###    ldap_opt_protocol_version: 3
				        ###   ldap_opt_referrals: 0
				        # Optional: The elapsed time a connection can be idle before it is closed and reconnected. Default: 600. To
				        #   To disable this altogether set it to 0.
				        ##idle_reconnect: 600
				        # Optional: The elapsed time (in seconds) to attempt the initial connection to the LDAP server. If it cannot
				        #   establish a connection within this time it will consider the server unreachable/down. Default: 1
				        ##connect_timeout: 5
				    # Any number of additional domains can be added.
				?>
			</div>
		</div>
		<div class="firstBoxDev">
			<div class="innerFirstDevBox"  >
				<div class="devBoxTitle">
					<b>LDAP Server Settings</b> 
				</div>
				<div class="devBoxContent">
					<ul class="settingsUl">
						<li>
						<a class="buttonButton" onclick="newDomainLDAP()" >Add Domain</a>
						</li>
					</ul>
				</div>
				<span id="newDomainLDAPLOcation" ></span>
			</div>
		</div>
	<?php elseif ($loginAuthType == 'PHP' ): ?>
		<div class="firstBoxDev">
			
		</div>
	<?php elseif ($loginAuthType == 'GitHub'): ?>
		<div class="firstBoxDev">
			
		</div>
	<?php else: ?>
		<div class="firstBoxDev">
			<div class="innerFirstDevBox"  >
				<div class="devBoxTitle">
					<b>No Auth Type Selected</b> 
				</div>
				<div class="devBoxContent">
					Go back to settings to select an auth type.
				</div>
			</div>
		</div>
	<?php endif; ?>
	</div>
	<script src="core/js/allPages.js"></script>

<?php require_once('core/php/templateFiles/allPages.php') ?>
<?php readfile('core/html/popup.html') ?>
<script type="text/javascript">
		function calcuateWidth()
{
	var innerWidthWindow = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;
	if(document.getElementById("sidebar").style.width == '100px')
	{
		innerWidthWindow -= 103;
	}
	if(document.getElementById("sidebar").style.width == '100px')
	{
		document.getElementById("main").style.left = "103px";
	}
	else
	{
		document.getElementById("main").style.left = "0px";
	}
	var innerWidthWindowCalc = innerWidthWindow;
	var innerWidthWindowCalcAdd = 0;
	var numOfWindows = 0;
	var elementWidth = 410;
	while(innerWidthWindowCalc > elementWidth)
	{
		innerWidthWindowCalcAdd += elementWidth;
		numOfWindows++;
		
		innerWidthWindowCalc -= elementWidth;
	}
	var windowWidthText = ((innerWidthWindowCalcAdd)+40)+"px";
	document.getElementById("main").style.width = windowWidthText;
	var remainingWidth = innerWidthWindow - ((innerWidthWindowCalcAdd)+40);
	remainingWidth = remainingWidth / 2;
	var windowWidthText = remainingWidth+"px";
	document.getElementById("main").style.marginLeft = windowWidthText;
	document.getElementById("main").style.paddingRight = windowWidthText;
	document.getElementById("widthForWatchListSection").style.width = ((innerWidthWindowCalcAdd))+"px";
}
</script>
<script type="text/javascript">

var currentServerCount = 1;

	function newDomainLDAP()
	{

		newHTML = "<li>Domain Name: <input type='text' name='domain_name_"+currentServerCount+"' ></li>";
		newHTML += "<li>Username: <input type='text' name='username_"+currentServerCount+"' ></li>";
		newHTML += "<li>Password: <input type='text' name='password_"+currentServerCount+"' ></li>";
		newHTML += "<li>Default Naming Context: <input type='text' name='default_naming_context"+currentServerCount+"' ></li>";

		currentServerCount++;
	}

	function removeDomainInLDAP()
	{



		currentServerCount--;
	}
</script>
</body>
