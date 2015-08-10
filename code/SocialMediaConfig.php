<?php

class SocialMediaConfig extends DataExtension {

	private static $db = array(

		'FacebookAppId'						=> 'Varchar(255)',
		'FacebookAppSecret'					=> 'Varchar(255)',
		'FacebookUserId'					=> 'Varchar(255)',
		'FacebookUserAccessToken'			=> 'Varchar(255)',
		'FacebookUserAccessTokenExpires'	=> 'SS_DateTime',
		'FacebookPageId'					=> 'Varchar(255)',
		'FacebookPageAccessToken'			=> 'Varchar(255)',
		'FacebookPageAccessTokenExpires'	=> 'SS_DateTime',
		'FacebookPageLink'					=> 'Varchar(255)',
		'FacebookPushUpdates'				=> 'Boolean',
		'FacebookPullUpdates'				=> 'Boolean',

		'TwitterConsumerKey'				=> 'Varchar(255)',
		'TwitterConsumerSecret'				=> 'Varchar(255)',
		'TwitterOAuthToken'					=> 'Varchar(255)',
		'TwitterOAuthTokenExpires'			=> 'SS_DateTime',
		'TwitterOAuthSecret'				=> 'Varchar(255)',
		'TwitterPageLink'					=> 'Varchar(255)',
		'TwitterUsername'					=> 'Varchar(255)',
		'TwitterPushUpdates'				=> 'Boolean',
		'TwitterPullUpdates'				=> 'Boolean',

		'InstagramApiKey'					=> 'Varchar(255)',
		'InstagramApiSecret'				=> 'Varchar(255)',
		'InstagramOAuthToken'				=> 'Varchar(255)',
		'InstagramOAuthTokenExpires'		=> 'SS_DateTime',
		'InstagramOAuthSecret'				=> 'Varchar(255)',
		'InstagramPageLink'					=> 'Varchar(255)',
		'InstagramUsername'					=> 'Varchar(255)',
		'InstagramPushUpdates'				=> 'Boolean',
		'InstagramPullUpdates'				=> 'Boolean'
	);

	public function updateCMSFields(FieldList $fields) {

		// Facebook
		// --------

		$fields->addFieldsToTab('Root.SocialMedia',	new LiteralField('FacebookHeading',	'<h3>Facebook</h3>'));

		// Validate Page Access Token
		$userValid = $pageValid = false;
		try {
			$pageValid = FBAuthenticator::validate_current_conf('page');
		} catch (Exception $e) {
			$pageMsg = $e->getMessage();
			// $this->owner->FacebookPageAccessToken = null;
			// $this->owner->write();
			$fields->addFieldsToTab('Root.SocialMedia',	new LiteralField(
				'FacebookBrokenPageConf',
				'<span style="color:red">Your facebook page configuration is broken (' . $pageValid . ')</span>'
			));
		}

		// Validate User Access Token
		try {
			$userValid = FBAuthenticator::validate_current_conf('user');
		} catch (Exception $e) {
			$userMsg = $e->getMessage();
			// $this->owner->FacebookUserAccessToken = null;
			// $this->owner->write();
			$fields->addFieldsToTab('Root.SocialMedia',	new LiteralField(
				'FacebookBrokenUserConf',
				'<p style="color:red">Your facebook user configuration is broken (' . $userMsg . ')</p>'
			));

		}

		$fields->addFieldsToTab('Root.SocialMedia', new LiteralField('FacebookAppLink', 'Manage your apps here: <a href="https://developers.facebook.com/apps/">https://developers.facebook.com/apps/</a>'));
		$fields->addFieldsToTab('Root.SocialMedia', new LiteralField('FacebookIDLink', 'Find your FB ID here: <a href="http://findmyfbid.com/">http://findmyfbid.com/</a>'));
		$fields->addFieldsToTab('Root.SocialMedia',	new TextField('FacebookAppId', 'Facebook App Id'));
		$fields->addFieldsToTab('Root.SocialMedia',	new TextField('FacebookAppSecret', 'Facebook App Secret'));
		$fields->addFieldsToTab('Root.SocialMedia',	new TextField('FacebookUserId', 'Facebook User Id'));
		$fields->addFieldsToTab('Root.SocialMedia',	new TextField('FacebookPageId', 'Facebook Page Id'));
		$fields->addFieldsToTab('Root.SocialMedia',	new TextField('FacebookPageLink', 'Facebook Page Link'));
		$fields->addFieldsToTab('Root.SocialMedia',	new CheckboxField('FacebookPushUpdates', 'Push publication updates to authorised Facebook account'));
		$fields->addFieldsToTab('Root.SocialMedia',	new CheckboxField('FacebookPullUpdates', 'Pull publication updates from authorised Facebook account'));
		$fields->addFieldsToTab('Root.SocialMedia',	new LiteralField('FacebookUserAccessToken', '<p>Facebook User Access Token</p><p>'.($this->owner->FacebookUserAccessToken ? $this->owner->FacebookUserAccessToken.' <a href="/FBAuthenticator/purge" target="_blank">Wipe</a>' : '<a href="/FBAuthenticator" target="_blank">Authenticate</a>').'</p>'));
		$fields->addFieldsToTab('Root.SocialMedia',	new LiteralField('FacebookPageAccessToken', '<p>Facebook Page Access Token</p><p>'.($this->owner->FacebookPageAccessToken ? $this->owner->FacebookPageAccessToken.' <a href="/FBAuthenticator/purge" target="_blank">Wipe</a>' : '<a href="/FBAuthenticator" target="_blank">Authenticate</a>').'</p>'));


		// Twitter
		// -------

		$fields->addFieldsToTab('Root.SocialMedia',	new LiteralField('TwitterHeading', '<h3>Twitter</h3>'));

		// user
		try {
			$twitterValid = TwitterAuthenticator::validate_current_conf();
		} catch (Exception $e) {
			$twitterMsg = $e->getMessage();
			// $this->owner->TwitterOAuthToken = null;
			// $this->owner->write();
			$fields->addFieldsToTab('Root.SocialMedia',	new LiteralField(
				'TwitterBrokenConf',
				'<p style="color:red">Your twitter configuration is broken</p>'
			));

		}

		$fields->addFieldsToTab('Root.SocialMedia', new LiteralField('TwitterAppLink', 'Manage your apps here: <a href="https://apps.twitter.com/">https://apps.twitter.com/</a>'));
		$fields->addFieldsToTab('Root.SocialMedia',	new TextField('TwitterConsumerKey', 'Twitter Consumer Key'));
		$fields->addFieldsToTab('Root.SocialMedia',	new TextField('TwitterConsumerSecret', 'Twitter Consumer Secret'));
		$fields->addFieldsToTab('Root.SocialMedia',	new TextField('TwitterPageLink', 'Twitter Page Link'));
		$fields->addFieldsToTab('Root.SocialMedia',	new TextField('TwitterUsername', 'Twitter Username'));
		$fields->addFieldsToTab('Root.SocialMedia',	new CheckboxField('TwitterPushUpdates', 'Push publication updates to authorised Twitter account'));
		$fields->addFieldsToTab('Root.SocialMedia',	new CheckboxField('TwitterPullUpdates', 'Pull publication updates from authorised Twitter account'));
		$fields->addFieldsToTab('Root.SocialMedia',	new LiteralField('TwitterOAuthToken', '<p>Twiter OAuth Token</p><p>'.($this->owner->TwitterOAuthToken ? $this->owner->TwitterOAuthToken.' <a href="/TwitterAuthenticator?wipe=1" target="_blank">Wipe</a>' : '<a href="/TwitterAuthenticator?start=1" target="_blank">Authenticate</a>').'</p>'));
		$fields->addFieldsToTab('Root.SocialMedia',	new LiteralField('TwitterOAuthSecret', '<p>Twiter OAuth Secret</p><p>'.($this->owner->TwitterOAuthSecret ? $this->owner->TwitterOAuthSecret.' <a href="/TwitterAuthenticator?wipe=1" target="_blank">Wipe</a>' : '<a href="/TwitterAuthenticator?start=1" target="_blank">Authenticate</a>').'</p>'));

		// Instagram
		// -------

		$fields->addFieldsToTab('Root.SocialMedia',	new LiteralField('InstagramHeading', '<h3>Instagram</h3>'));

		// user
		try {
			$instagramValid = InstagramAuthenticator::validate_current_conf();
		} catch (Exception $e) {
			$instagramMsg = $e->getMessage();
			$fields->addFieldsToTab('Root.SocialMedia',	new LiteralField(
				'InstagramBrokenConf',
				'<p style="color:red">Your instagram configuration is broken</p>'
			));

		}

		$fields->addFieldsToTab('Root.SocialMedia', new LiteralField('InstagramAppLink', 'Manage your apps here: <a href="https://apps.twitter.com/">https://apps.twitter.com/</a>'));
		$fields->addFieldsToTab('Root.SocialMedia',	new TextField('InstagramApiKey', 'Instagram Key'));
		$fields->addFieldsToTab('Root.SocialMedia',	new TextField('InstagramApiSecret', 'Instagram Secret'));
		$fields->addFieldsToTab('Root.SocialMedia',	new TextField('InstagramPageLink', 'Instagram Page Link'));
		$fields->addFieldsToTab('Root.SocialMedia',	new TextField('InstagramUsername', 'Instagram Username'));
		$fields->addFieldsToTab('Root.SocialMedia',	new CheckboxField('InstagramPushUpdates', 'Push publication updates to authorised Instagram account'));
		$fields->addFieldsToTab('Root.SocialMedia',	new CheckboxField('InstagramPullUpdates', 'Pull publication updates from authorised Instagram account'));
		$fields->addFieldsToTab('Root.SocialMedia',	new LiteralField('InstagramOAuthToken', '<p>Twiter OAuth Token</p><p>'.($this->owner->InstagramOAuthToken ? $this->owner->InstagramOAuthToken.' <a href="/InstagramAuthenticator?wipe=1" target="_blank">Wipe</a>' : '<a href="/InstagramAuthenticator?start=1" target="_blank">Authenticate</a>').'</p>'));
		$fields->addFieldsToTab('Root.SocialMedia',	new LiteralField('InstagramOAuthSecret', '<p>Twiter OAuth Secret</p><p>'.($this->owner->InstagramOAuthSecret ? $this->owner->InstagramOAuthSecret.' <a href="/InstagramAuthenticator?wipe=1" target="_blank">Wipe</a>' : '<a href="/InstagramAuthenticator?start=1" target="_blank">Authenticate</a>').'</p>'));

		return $fields;

	}
}
