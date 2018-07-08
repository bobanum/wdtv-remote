<xsl:stylesheet
	version="1.0"
	xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
	xmlns:u="urn:schemas-upnp-org:device-1-0"
	xmlns:s="urn:schemas-upnp-org:service-1-0"
	xmlns:ms="urn:microsoft-com:wmc-1-0"
	xmlns:dlna="urn:schemas-dlna-org:device-1-0"
	xmlns:pnpx="http://schemas.microsoft.com/windows/pnpx/2005/11"
	xpath-default-namespace="urn:schemas-upnp-org:device-1-0"
	xmlns:df="http://schemas.microsoft.com/windows/2008/09/devicefoundation">

	<xsl:template match="/">
		<html>

		<body>
<!--			<xsl:apply-templates select="/u:root"/>-->
			<xsl:apply-templates select="/u:root/u:device/u:serviceList"/>
			<xsl:apply-templates select="/s:scpd/s:actionList"/>
			<!--				<xsl:apply-templates select="/s:scpd"/>-->
		</body>

		</html>
	</xsl:template>
	<xsl:template match="u:serviceList">
		<h3>Services</h3>
		<ul>
			<xsl:for-each select="*">
				<li>
					<span>
						<xsl:value-of select="name()"/>
						<a>
							<xsl:attribute name="href">
								<xsl:text>?xml=</xsl:text>
								<xsl:value-of select="u:SCPDURL"/>
							</xsl:attribute>
							<xsl:value-of select="u:serviceId"/>
						</a>
					</span>
				</li>
			</xsl:for-each>
		</ul>
	</xsl:template>
	<xsl:template match="s:actionList">
		<h3>Actions</h3>
		<ul>
			<xsl:for-each select="*">
				<li>
					<span>
						<xsl:value-of select="s:name"/>
					</span>
					<xsl:apply-templates select="s:argumentList"/>
				</li>
			</xsl:for-each>
		</ul>
	</xsl:template>
	<xsl:template match="s:argumentList">
		<ul>
			<xsl:for-each select="*">
				<li>
					<xsl:value-of select="s:direction"/> :
					<span>
						<xsl:value-of select="s:name"/>
					</span>
					<span>
						(<xsl:value-of select="s:relatedStateVariable"/>)
					</span>
				</li>
			</xsl:for-each>
		</ul>
	</xsl:template>

</xsl:stylesheet>
