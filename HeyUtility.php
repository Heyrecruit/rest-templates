<?php
	declare(strict_types=1);
	require_once __DIR__ . '/vendor/autoload.php';
	
	use Heyrecruit\HeyRestApi;
	
	const DS = '/';
	
	/**
	 * A utility class with various helpful functions.
	 */
	class HeyUtility
	{
		private HeyRestApi $scope;
		private array $company;
		
		public function __construct(array $env)
		{
			$this->initializeScope($env);
			$this->initializeCompany();
			$this->setReferrer();
		}
		
		/**
		 * Initializes the HeyRestApi with the environment variables.
		 *
		 * @param array $env The environment variables.
		 * @return void
		 */
		private function initializeScope(array $env): void
		{
			try {
				$this->scope = new HeyRestApi($env);
			} catch (Exception $e) {
				die($e->getMessage());
			}
		}
		
		/**
		 * Sets the referrer for the HeyRestApi.
		 *
		 * @return void
		 */
		private function setReferrer(): void
		{
			$pageURL = $this->getCurrentPageUrl();
			
			$referrer = $_SERVER['HTTP_REFERER'] ?? $pageURL;
			
			if (
				!isset($_SESSION['referrer']) ||
				strtolower(parse_url($referrer, PHP_URL_HOST)) != strtolower($_SERVER['HTTP_HOST'])
			) {
				$_SESSION['referrer'] = $referrer;
			}
		}
		
		/**
		 * Returns the current page URL.
		 *
		 * This function constructs the current page URL using PHP's `$_SERVER` superglobal.
		 * It determines the scheme (HTTP or HTTPS), the host name, and the request URI to construct the URL.
		 *
		 * @return string The current page URL.
		 */
		public function getCurrentPageUrl(): string{
			$pageURL = 'http';
			if (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") {
				$pageURL .= "s";
			}
			
			$pageURL .= "://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
			
			return $pageURL;
		}
		
		/**
		 * Returns the HeyRestApi instance.
		 *
		 * @return HeyRestApi The HeyRestApi instance.
		 */
		public function getScope(): HeyRestApi
		{
			return $this->scope;
		}
		
		/**
		 * Returns the company object.
		 *
		 * @return array The company object.
		 */
		public function getCompany(): array
		{
			return $this->company;
		}
		
		/**
		 * Defines the necessary constants for the current template path.
		 *
		 * @param string $templatePath The template path.
		 * @return void
		 */
		public function defineConstants(string $templatePath): void{
			
			define("ROOT", $_SERVER['DOCUMENT_ROOT'] . $_ENV['BASE_PATH'] . DS);
			
			define("CURRENT_TEMPLATE_PATH", ROOT . 'templates' . DS . $templatePath . DS);
			
			define("CURRENT_SECTION_PATH", CURRENT_TEMPLATE_PATH . 'sections' . DS);
			define("CURRENT_ELEMENT_PATH", CURRENT_TEMPLATE_PATH . 'elements' . DS);
			define("CURRENT_PAGE_PATH", CURRENT_TEMPLATE_PATH . 'pages' . DS);
			define("ELEMENT_PATH_ROOT", ROOT . 'elements' . DS);
			define("FONT_PATH_ROOT", ROOT . 'font' . DS);
			define("VERSION", '2.0');
		}
		
		/**
		 * Returns the template folder of the company.
		 *
		 * @return string The template folder of the company.
		 */
		public function getTemplateFolder(): string
		{
			return $this->company['company_templates']['template_folder'] ?? '';
		}
	
		/**
		 * Initializes the company object based on the subdomain parameter.
		 *
		 * @return void
		 */
		private function initializeCompany(): void
		{
			$subDomain = explode('.', $_SERVER['HTTP_HOST'])[0];
			
			try {
				$company = $this->scope->getCompanyDetailBySubDomain($subDomain);
				
				if ($company['status_code'] !== 200) {
					$company = $this->scope->getCompanyDetail((int) $_ENV['SCOPE_CLIENT_ID']);
				}
				
				if ($company['status_code'] !== 200) {
					$message = $company['response']['errors'] ?? 'Es ist ein Fehler aufgetreten.';
					die($message);
				}
				
				$this->company = $company['response']['data'];
			} catch (Exception $e) {
				die('Es ist ein Fehler aufgetreten.');
			}
		}
		
		/**
		 * Get jobs based on the provided filter.
		 *
		 *  @param array|string $filter The filter to apply to the jobs.
		 * @return array The jobs matching the filter.
		 * @throws Exception If there is an error while loading the job listings.
		 */
		public function getJobs($filter = ''): array
		{
			try {
				
				if(is_array($filter)) {
					$filter = http_build_query($filter);
				}
			
				if(!empty($filter)) {
					$this->scope->setFilter($filter);
				}
				
				$jobs = $this->scope->getJobs($this->company['id']);
				
				if ($jobs['status_code'] === 200) {
					return $jobs['response']['data'] ?? [];
				} else {
					throw new Exception($jobs['response']['message']);
				}
			} catch (Exception $e) {
				throw new Exception('Error while loading job listings.', 0, $e);
			}
		}
		
		public function apply(array $applicant, $reCaptchaToken = null, array $files = []): array {
			
			$applicant['files'] = $files;
			
			$data = [
				'applicant' => $applicant,
				'analytics' => [
					'referrer' => $_SESSION['referrer'] ?? $this->getCurrentPageUrl()
				]
			];
			
			if(!empty($reCaptchaToken)){
				$data['re_captcha'] = $reCaptchaToken;
			}
			
			return $this->scope->apply($data);
		}
		
		/**
		 * Process uploaded files into required structure.
		 *
		 * @param string $fileType The type of the file to be processed.
		 * @param string $questionId
		 * @param array $file
		 * @return array An array containing processed file data.
		 */
		public function processUploadedFiles(string $fileType, string $questionId, array $file): array
		{
			$processedFiles = [];
			
			$uploadedFile = $file['file'];
			
			// Ensure the file upload didn't encounter any errors.
			if ($uploadedFile['error'] === UPLOAD_ERR_OK) {
				// Retrieve file information.
				$fileName = $uploadedFile['name'];
				$contentType = mime_content_type($uploadedFile['tmp_name']);
				
				// Retrieve and base64 encode the file data.
				$fileData = base64_encode(file_get_contents($uploadedFile['tmp_name']));
				
				// Add processed file to the array.
				$processedFiles = [
					'name' => $fileName,
					'type' => $fileType,
					'content_type' => $contentType,
					'question_id' => $questionId,
					'data' => $fileData,
				];
			}
			
			return $processedFiles;
		}
		
		/**
		 * Retrieves a question string based on the provided language ID from a given data array.
		 *
		 * @param array $data The data array containing the question strings.
		 * @param int $languageId The language ID for which to retrieve the question string.
		 * @param string $field The field name of the question string in the data array.
		 * @return string The question string based on the provided language ID.
		 */
		public static function getQuestionStringBasedOnLanguage(array $data, int $languageId, string $field): string
		{
			$string = '';
			$fallBackString = '';
			
			if (!empty($data)) {
				foreach ($data as $value) {
					
					if(isset($value[$field]) && $value['language_id'] == $languageId && !empty($value[$field])){
						$string = $value[$field];
					}
					
					if($languageId === 1 && !empty($value[$field])){
						$fallBackString = $value[$field];
					}
				}
			}
			
			return empty($string) ? $fallBackString : $string;
		}
		
		/**
		 * Updates a base array with values from a GET parameters array, while ensuring type safety.
		 * Only updates keys that exist in the base array and are allowed.
		 *
		 * @param array $baseArray The original array to be updated.
		 * @param array $getParams An associative array of parameters, typically $_GET.
		 * @param array $allowedKeys An array of keys that are allowed to be updated.
		 *
		 * @return array The updated array with values from $getParams.
		 */
		public static function updateArrayWithGetParams(array $baseArray, array $getParams, array $allowedKeys): array {
			foreach ($getParams as $key => $value) {
				if (in_array($key, $allowedKeys) && array_key_exists($key, $baseArray)) {
					// Typsicherheit gewährleisten
					if (is_int($baseArray[$key])) {
						$baseArray[$key] = (int) $value;
					} elseif (is_bool($baseArray[$key])) {
						$baseArray[$key] = filter_var($value, FILTER_VALIDATE_BOOLEAN);
					} elseif(is_string($baseArray[$key])) {
						$baseArray[$key] = (string) $value;
					}elseif(is_array($baseArray[$key])){
						$baseArray[$key] = $value;
					}
				}
			}
			return $baseArray;
		}
		
		
		/**
		 * Formats a company location as a human-readable address string.
		 *
		 * @param array $companyLocation An associative array containing the address data.
		 * @param bool $street Whether to include the street name and number in the address.
		 * @param bool $city Whether to include the city name in the address.
		 * @param bool $state Whether to include the state or province in the address.
		 * @param bool $country Whether to include the country name in the address.
		 *
		 * @return string The formatted address string.
		 */
		public static function getFormattedAddress(
			array $companyLocation = [],
			bool $street = true,
			bool $city = true,
			bool $state = true,
			bool $country = true,
			bool $title = true
		): string {
			
			$address = '';
			$hasAddress = false;
			
			if (!empty($companyLocation)) {
				
				if($title && !empty($companyLocation['company_location']['title'])) {
					return $companyLocation['company_location']['title'];
				}
				
				if ($street) {
					$address .= $companyLocation['company_location']['street'] ?? '';
					$address .= ' ' . ($companyLocation['company_location']['street_number'] ?? '');
					$hasAddress = !empty(trim($address));
				}
				
				if ($city) {
					$address .= $hasAddress ? ', ' : '';
					$address .= $companyLocation['company_location']['city'] ?? '';
					$hasAddress = !empty(trim($address));
				}
				
				if ($state) {
					$address .= $hasAddress ? ', ' : '';
					$address .= $companyLocation['company_location']['state'] ?? '';
					$hasAddress = !empty(trim($address));
				}
				
				if ($country) {
					$address .= $hasAddress ? ', ' : '';
					$address .= $companyLocation['company_location']['country'] ?? '';
				}
			}
			
			return $address;
		}
		
		/**
		 * Convert a hexadecimal color code to RGB(A) format.
		 *
		 * @param string $color The hexadecimal color code to convert.
		 * @param float|bool $opacity The opacity value for RGBA format. If false, only RGB format is returned.
		 *
		 * @return string Returns the RGB(A) color string.
		 */
		public static function hex2rgba(string $color, $opacity = false): string {
			$default = 'rgb(0,0,0)';
			
			// Return default if no color provided
			if (empty($color)) {
				return $default;
			}
			
			// Sanitize $color if "#" is provided
			if ($color[0] === '#') {
				$color = substr($color, 1);
			}
			
			// Check if color has 6 or 3 characters and get values
			if (strlen($color) === 6) {
				$hex = [
					$color[0] . $color[1],
					$color[2] . $color[3],
					$color[4] . $color[5]
				];
			} elseif (strlen($color) === 3) {
				$hex = [
					$color[0] . $color[0],
					$color[1] . $color[1],
					$color[2] . $color[2]
				];
			} else {
				return $default;
			}
			
			// Convert hexadec to rgb
			$rgb = array_map('hexdec', $hex);
			
			// Check if opacity is set (rgba or rgb)
			if ($opacity !== false) {
				$opacity = abs($opacity) > 1 ? 1.0 : $opacity;
				$output = 'rgba(' . implode(",", $rgb) . ',' . $opacity . ')';
			} else {
				$output = 'rgb(' . implode(",", $rgb) . ')';
			}
			
			// Return rgb(a) color string
			return $output;
		}
		
		/**
		 * Get the metadata for a specific page.
		 *
		 * @param string $page The page identifier.
		 * @param array $company The company data.
		 *
		 * @return array The metadata for the specified page.
		 */
		public static function getPageMetadata(string $page, array $company): array
		{
			$metadata = [
				'jobs' => [
					'title' => 'Karriere bei ' . $company['name'],
					'description' => 'Das Karriereportal der ' . $company['name'] . '. Alle offenen Stellen der ' . $company['name'] . ' auf einen Blick.'
				],
				'job' => [
					'title' => 'Karriere bei ' . $company['name'],
					'description' => 'Das Karriereportal der ' . $company['name'] . '. Alle offenen Stellen der ' . $company['name'] . ' auf einen Blick.'
				]
			];
			
			if (isset($metadata[$page]) && is_array($metadata[$page])) {
				$meta = $metadata[$page];
			} else {
				$meta = [
					'title' => 'Karriereportal - ' . $company['name'],
					'description' => 'Geh deinen Weg mit uns'
				];
			}
			
			return $meta;
		}
		
		/**
		 * Get the current page identifier.
		 *
		 * @param array $request The request parameters.
		 * @return string The current page identifier.
		 */
		public static function getCurrentPage(array $request): string
		{
			$allowedPages = ['job', 'apply', 'jobs', 'error', 'success', 'danke', 'fehler', 'ueber-uns',
                'datenschutz', 'impressum', 'faq', 'erfahrungsberichte-kfm-mitarbeiter',
                'erfahrungsberichte-kraftfahrer', 'aus-und-weiterbildung-kraftfahrer', 'karrieremoeglichkeiten-kraftfahrer'];
			
			$currentPage = $request['page'] ?? 'jobs';
			$currentPage = strtolower(preg_replace("/[^a-zA-Z0-9_äüö-]/", "", $currentPage));
			
			if (!in_array($currentPage, $allowedPages)) {
				$currentPage = 'jobs';
			}
			
			return $currentPage;
		}
		
		/**
		 * Include specific sections based on the provided array of sections and section types.
		 *
		 * @param array $sections Array of sections containing job sections.
		 * @param array $includeSectionType Array of section types to include.
		 * @param array $vars
		 * @return void
		 */
		public static function includeSections(array $sections, array $includeSectionType = [], array $vars = []): void{
			if (!empty($sections)) {
				foreach ($sections as $key => $value) {
					if (
						file_exists(CURRENT_SECTION_PATH . $value['section_type'] . '.php') &&
						(empty($includeSectionType) || in_array($value['section_type'], $includeSectionType))
					) {
						$jobSection = $value;
						ob_start();
						include CURRENT_SECTION_PATH . $value['section_type'] . '.php';
						echo ob_get_clean();
					}
				}
			}
		}
		
		/**
		 * Retrieves section element images from a job array.
		 *
		 * @param array $job The job array.
		 * @return array The array of section element images.
		 */
		public static function getSectionElementImages(array $job): array{
			$images = [];
			if (!empty($job['job_sections'])) {
				foreach ($job['job_sections'] as $section) {
					if (!empty($section['job_section_elements']) && $section['section_type'] === 'header') {
						foreach ($section['job_section_elements'] as $element) {
							if ($element['element_type'] === 'image') {
							
								return json_decode($element['job_section_element_strings'][0]['text'], true);
							}
						}
					}
				}
			}
			
			return $images;
		}
		
		/**
		 * Get the formatted employee number.
		 *
		 * @param string|null $employeeNumber The employee number.
		 * @param string $langauge
		 * @return string The formatted employee number.
		 */
		public static function getFormattedEmployeeNumber(?string $employeeNumber, string $langauge = 'de'): string
		{
			
			if ($employeeNumber === 'greater 100') {
				return $langauge !== 'de' ? 'over 100' : 'über 100';
			} elseif ($employeeNumber === 'smaller 25') {
				return $langauge !== 'de' ? 'under 25' : 'unter 25';
			} else {
				return str_replace('-', '–', $employeeNumber ?? '');
			}
		}
		
		/**
		 * Shortcut function to escape HTML special characters.
		 *
		 * @param string|null $value The value to be escaped.
		 * @param int $flags The optional flags parameter.
		 * @param string $encoding The optional encoding parameter.
		 * @param bool $doubleEncode Whether to double encode existing entities.
		 * @return string|null The escaped value.
		 */
		public static function h(
			?string $value,
			int $flags = ENT_QUOTES,
			string $encoding = 'UTF-8',
			bool $doubleEncode = true
		): ?string
		{
			if(!empty($value)) {
				return str_replace('&amp;', '&', htmlspecialchars($value, $flags, $encoding, $doubleEncode));
			}else{
				return $value;
			}
		}
		
		/**
		 * Get the job ID from the given request array.
		 *
		 * @param array $request The request array.
		 * @return mixed|null The job ID, or null if it is not set.
		 */
		public static function getJobId(array $request): ?string
		{
			if (isset($request['job'])) {
				return $request['job'];
			} elseif (isset($request['id'])) {
				return $request['id'];
			}
			return null;
		}
		
		/**
		 * Get the company location ID from the given request array.
		 *
		 * @param array $request The request array.
		 * @return mixed|null The company location ID, or null if it is not set.
		 */
		public static function getLocationId(array $request): ?string
		{
			if (isset($request['location'])) {
				return $request['location'];
			} elseif (isset($request['companyLocationId'])) {
				return $request['companyLocationId'];
			}
			return null;
		}
		
		/**
		 * Generate the CSS styles based on the company's template colors.
		 *
		 * @param string $keyColor The key color value.
		 * @param string $secondaryColor The secondary color value.
		 * @return string The generated CSS styles.
		 */
		public static function generateCompanyStyles(string $keyColor, string $secondaryColor): string
		{
			$css = "
	            /* Set class to override the default template color outta scope */
	            .btn,
	            .btn.btn-subtle:hover,
	            #lang ul li:hover a,
	            .flexbox-badges span {
	                color: $keyColor;
	            }
	
	            .btn:hover,
	            .btn.btn-primary,
	            .dz-upload,
	            body section#cp-section-jobs #pagination button.active {
	                background: $keyColor;
	            }
	
	            .initiative-tile,
	            body section#cp-section-jobs #pagination button:not(.active):hover,
	            .flexbox-badges span,
	            body section .social-links a:hover {
	                background: " . self::hex2rgba($keyColor, 0.1) . ";
	            }
	
	            .primary-bg,
	            .primary-bg-hover:hover,
	            .primary-bg-before:before,
	            .primary-bg-before ul li:before {
	                background: $keyColor !important;
	            }
	
	            .primary-color,
	            .primary-color-hover:hover,
	            .primary-color-hover:hover span,
	            .primary-color-hover:hover i {
	                color: $keyColor !important;
	            }
	
	            body section#jp-section-form #job-form-wrapper select:focus,
	            body section#jp-section-form #job-form-wrapper select:hover,
	            body section#jp-section-form #job-form-wrapper textarea:focus,
	            body section#jp-section-form #job-form-wrapper textarea:hover,
	            body section#jp-section-form #job-form-wrapper input[type=text]:focus,
	            body section#jp-section-form #job-form-wrapper input[type=text]:hover,
	            body section#jp-section-form #job-form-wrapper input[type=email]:focus,
	            body section#jp-section-form #job-form-wrapper input[type=email]:hover,
	            body section#jp-section-form #job-form-wrapper input[type=tel]:focus,
	            body section#jp-section-form #job-form-wrapper input[type=tel]:hover,
	            .dz-default.dz-message > span,
	            .dz-default.dz-message > button {
	                border-color: $keyColor !important;
	            }
	
	            body #ui-datepicker-div .ui-datepicker-calendar .ui-state-default.ui-state-active {
	                border: 1px solid $keyColor !important;
	                background: $keyColor !important;
	            }
	
	            #kununu-svg {
	                fill: $keyColor !important;
	            }
	
	            .secondary-color,
	            .secondary-color-hover:hover {
	                color: $secondaryColor !important;
	            }
	
	            .secondary-bg,
	            .secondary-bg-hover:hover {
	                background: $secondaryColor !important;
	            }
            ";
			
			return $css;
		}
		
		/**
		 * Generate the data attributes for the <body> tag.
		 *
		 * @param string $basePath The base path value.
		 * @param string $template The template value.
		 * @param string $domain The domain value.
		 * @param string $companyName The company name value.
		 * @param string $keyColor The key color value.
		 * @param string|null $gtmId The Google Tag Manager ID value.
		 * @param string|null $gtmPropertyId The Google Analytics property ID value.
		 * @return string The generated data attributes.
		 */
		public static function getBodyDataAttributes(
			string $basePath,
			string $template,
			string $domain,
			string $companyName,
			string $keyColor,
			?string $gtmId = null,
			?string $gtmPropertyId = null
		): string {
			
			$gtmId = empty($gtmId) ? '' : $gtmId;
			$gtmPropertyId = empty($gtmPropertyId) ? '' : $gtmPropertyId;
			
			return sprintf(
				'data-base-path="%s/templates/%s" data-domain="%s" data-company-name="%s" data-key-color="%s" ' .
				'data-ga4-measurement-id="%s" data-gtm-property-id="_gat_%s" data-datenschutz-url="#scope_datenschutz"' .
				'data-datenschutz-class=""',
				$basePath,
				$template,
				$domain,
				$companyName,
				$keyColor,
				$gtmId,
				$gtmPropertyId
			);
		}
		
		public static function decodeJsonString(string $jsonString): ?array {
			$decoded = json_decode($jsonString, true);
			
			if (is_string($decoded)) {
				$decoded = json_decode($decoded, true);
			}
			
			if (json_last_error() === JSON_ERROR_NONE) {
				return $decoded;
			} else {
				return null;
			}
		}
		
		public static function redirectIfJobNotFound($job): void {
		
			// Job not found -> redirect to error page defined in .env
			if (empty($job) || empty($job['company_location_jobs'])) {
				$URL = $_ENV['BASE_PATH'] . '?page=' . $_ENV['ERROR_PAGE'] . '&code=404';
				if (headers_sent()) {
					echo("<script>window.location.href='$URL'</script>");
				} else {
					header("Location: $URL");
				}
				exit;
			}
		}
		
		public static function printH(array $data, bool $die = true): void{
			echo "<pre>";
			print_r($data);
			echo "</pre>";
			
			if($die){
				die;
			}
		}
		
		public static function env(string $key){
			
			if($_ENV[$key]){
				return $_ENV[$key];
			}
			
			return false;
		}
	}