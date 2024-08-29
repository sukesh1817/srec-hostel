<?php

// ******************************************************************************
// Software: mPDF, Unicode-HTML Free PDF generator                              *
// Version:  6.1        based on                                                *
//           FPDF by Olivier PLATHEY                                            *
//           HTML2FPDF by Renato Coelho                                         *
// Date:     2016-03-25                                                         *
// Author:   Ian Back <ianb@bpm1.com>                                           *
// License:  GPL                                                                *
//                                                                              *
// Changes:  See changelog.txt                                                  *
// ******************************************************************************

define('mPDF_VERSION', '6.1');

//Scale factor
define('_MPDFK', (72 / 25.4));

// Specify which font metrics to use:
// 'winTypo' uses sTypoAscender etc from the OS/2 table and is the one usually recommended - BUT
// 'win' use WinAscent etc from OS/2 and inpractice seems to be used more commonly in Windows environment
// 'mac' uses Ascender etc from hhea table, and is used on Mac/OSX environment
if (!defined('_FONT_DESCRIPTOR')) {
	define("_FONT_DESCRIPTOR", 'win'); // Values: '' [BLANK] or 'win', 'mac', 'winTypo'
}

/* -- HTML-CSS -- */
define('_BORDER_ALL', 15);
define('_BORDER_TOP', 8);
define('_BORDER_RIGHT', 4);
define('_BORDER_BOTTOM', 2);
define('_BORDER_LEFT', 1);
/* -- END HTML-CSS -- */

// mPDF 6.0
// Used for $textvars - user settings via CSS
define('FD_UNDERLINE', 1); // font-decoration
define('FD_LINETHROUGH', 2);
define('FD_OVERLINE', 4);
define('FA_SUPERSCRIPT', 8); // font-(vertical)-align
define('FA_SUBSCRIPT', 16);
define('FT_UPPERCASE', 32); // font-transform
define('FT_LOWERCASE', 64);
define('FT_CAPITALIZE', 128);
define('FC_KERNING', 256); // font-(other)-controls
define('FC_SMALLCAPS', 512);


if (!defined('_MPDF_PATH')) {
	define('_MPDF_PATH', dirname(preg_replace('/\\\\/', '/', __FILE__)) . '/');
}

if (!defined('_MPDF_URI')) {
	define('_MPDF_URI', _MPDF_PATH);
}

require_once _MPDF_PATH . 'includes/functions.php';
require_once _MPDF_PATH . 'config_lang2fonts.php';

require_once _MPDF_PATH . 'classes/ucdn.php'; // mPDF 6.0

/* -- OTL -- */
require_once _MPDF_PATH . 'classes/indic.php'; // mPDF 6.0
require_once _MPDF_PATH . 'classes/myanmar.php'; // mPDF 6.0
require_once _MPDF_PATH . 'classes/sea.php'; // mPDF 6.0
/* -- END OTL -- */

require_once _MPDF_PATH . 'Tag.php';
require_once _MPDF_PATH . 'MpdfException.php';

if (!defined('_JPGRAPH_PATH')) {
	define("_JPGRAPH_PATH", _MPDF_PATH . 'jpgraph/');
}

if (!defined('_MPDF_TEMP_PATH')) {
	define("_MPDF_TEMP_PATH", _MPDF_PATH . 'tmp/');
}

if (!defined('_MPDF_TTFONTPATH')) {
	define('_MPDF_TTFONTPATH', _MPDF_PATH . 'ttfonts/');
}

if (!defined('_MPDF_TTFONTDATAPATH')) {
	define('_MPDF_TTFONTDATAPATH', _MPDF_PATH . 'ttfontdata/');
}

$errorlevel = error_reporting();
$errorlevel = error_reporting($errorlevel & ~E_NOTICE);

//error_reporting(E_ALL);

if (function_exists("date_default_timezone_set")) {
	if (ini_get("date.timezone") == "") {
		date_default_timezone_set("Europe/London");
	}
}

if (!function_exists('mb_strlen')) {
	throw new MpdfException('mPDF requires mb_string functions. Ensure that mb_string extension is loaded.');
}

if (!defined('PHP_VERSION_ID')) {
	$version = explode('.', PHP_VERSION);
	define('PHP_VERSION_ID', ($version[0] * 10000 + $version[1] * 100 + $version[2]));
}

class mPDF
{

	///////////////////////////////
	// EXTERNAL (PUBLIC) VARIABLES
	// Define these in config.php
	///////////////////////////////
	var $useFixedNormalLineHeight; // mPDF 6
	var $useFixedTextBaseline; // mPDF 6
	var $adjustFontDescLineheight; // mPDF 6
	var $interpolateImages; // mPDF 6
	var $defaultPagebreakType; // mPDF 6 pagebreaktype
	var $indexUseSubentries; // mPDF 6

	var $autoScriptToLang; // mPDF 6
	var $baseScript; // mPDF 6
	var $autoVietnamese; // mPDF 6
	var $autoArabic; // mPDF 6

	var $CJKforceend;
	var $h2bookmarks;
	var $h2toc;
	var $decimal_align;
	var $margBuffer;
	var $splitTableBorderWidth;

	var $bookmarkStyles;
	var $useActiveForms;

	var $repackageTTF;
	var $allowCJKorphans;
	var $allowCJKoverflow;

	var $useKerning;
	var $restrictColorSpace;
	var $bleedMargin;
	var $crossMarkMargin;
	var $cropMarkMargin;
	var $cropMarkLength;
	var $nonPrintMargin;

	var $PDFX;
	var $PDFXauto;

	var $PDFA;
	var $PDFAauto;
	var $ICCProfile;

	var $printers_info;
	var $iterationCounter;
	var $smCapsScale;
	var $smCapsStretch;

	var $backupSubsFont;
	var $backupSIPFont;
	var $debugfonts;
	var $useAdobeCJK;
	var $percentSubset;
	var $maxTTFFilesize;
	var $BMPonly;

	var $tableMinSizePriority;

	var $dpi;
	var $watermarkImgAlphaBlend;
	var $watermarkImgBehind;
	var $justifyB4br;
	var $packTableData;
	var $pgsIns;
	var $simpleTables;
	var $enableImports;

	var $debug;

	var $showStats;
	var $setAutoTopMargin;
	var $setAutoBottomMargin;
	var $autoMarginPadding;
	var $collapseBlockMargins;
	var $falseBoldWeight;
	var $normalLineheight;
	var $progressBar;
	var $incrementFPR1;
	var $incrementFPR2;
	var $incrementFPR3;
	var $incrementFPR4;

	var $SHYlang;
	var $SHYleftmin;
	var $SHYrightmin;
	var $SHYcharmin;
	var $SHYcharmax;
	var $SHYlanguages;

	// PageNumber Conditional Text
	var $pagenumPrefix;
	var $pagenumSuffix;

	var $nbpgPrefix;
	var $nbpgSuffix;
	var $showImageErrors;
	var $allow_output_buffering;
	var $autoPadding;
	var $useGraphs;
	var $tabSpaces;
	var $autoLangToFont;
	var $watermarkTextAlpha;
	var $watermarkImageAlpha;
	var $watermark_size;
	var $watermark_pos;
	var $annotSize;
	var $annotMargin;
	var $annotOpacity;
	var $title2annots;
	var $keepColumns;
	var $keep_table_proportions;
	var $ignore_table_widths;
	var $ignore_table_percents;
	var $list_number_suffix;

	var $list_auto_mode; // mPDF 6
	var $list_indent_first_level; // mPDF 6
	var $list_indent_default; // mPDF 6
	var $list_marker_offset; // mPDF 6

	var $useSubstitutions;
	var $CSSselectMedia;

	var $forcePortraitHeaders;
	var $forcePortraitMargins;
	var $displayDefaultOrientation;
	var $ignore_invalid_utf8;
	var $allowedCSStags;
	var $onlyCoreFonts;
	var $allow_charset_conversion;

	var $jSWord;
	var $jSmaxChar;
	var $jSmaxCharLast;
	var $jSmaxWordLast;

	var $max_colH_correction;

	var $table_error_report;
	var $table_error_report_param;
	var $biDirectional;
	var $text_input_as_HTML;
	var $anchor2Bookmark;
	var $shrink_tables_to_fit;

	var $allow_html_optional_endtags;

	var $img_dpi;

	var $defaultheaderfontsize;
	var $defaultheaderfontstyle;
	var $defaultheaderline;
	var $defaultfooterfontsize;
	var $defaultfooterfontstyle;
	var $defaultfooterline;
	var $header_line_spacing;
	var $footer_line_spacing;

	var $pregCJKchars;
	var $pregRTLchars;
	var $pregCURSchars; // mPDF 6

	var $mirrorMargins;
	var $watermarkText;
	var $watermarkImage;
	var $showWatermarkText;
	var $showWatermarkImage;

	var $fontsizes;

	var $defaultPageNumStyle; // mPDF 6

	//////////////////////
	// CLASS OBJECTS
	//////////////////////
	var $otl; // mPDF 5.7.1
	var $cssmgr;
	var $grad;
	var $bmp;
	var $wmf;
	var $tocontents;
	var $mpdfform;
	var $directw;

	//////////////////////
	// INTERNAL VARIABLES
	//////////////////////
	var $script2lang;
	var $viet;
	var $pashto;
	var $urdu;
	var $persian;
	var $sindhi;
	var $extrapagebreak; // mPDF 6 pagebreaktype

	var $uniqstr; // mPDF 5.7.2
	var $hasOC;

	var $textvar; // mPDF 5.7.1
	var $fontLanguageOverride; // mPDF 5.7.1
	var $OTLtags; // mPDF 5.7.1
	var $OTLdata;  // mPDF 5.7.1

	var $writingToC;
	var $layers;
	var $current_layer;
	var $open_layer_pane;
	var $decimal_offset;
	var $inMeter;

	var $CJKleading;
	var $CJKfollowing;
	var $CJKoverflow;

	var $textshadow;

	var $colsums;
	var $spanborder;
	var $spanborddet;

	var $visibility;

	var $useRC128encryption;
	var $uniqid;

	var $kerning;
	var $fixedlSpacing;
	var $minwSpacing;
	var $lSpacingCSS;
	var $wSpacingCSS;

	var $spotColorIDs;
	var $SVGcolors;
	var $spotColors;
	var $defTextColor;
	var $defDrawColor;
	var $defFillColor;

	var $tableBackgrounds;
	var $inlineDisplayOff;
	var $kt_y00;
	var $kt_p00;
	var $upperCase;
	var $checkSIP;
	var $checkSMP;
	var $checkCJK;

	var $watermarkImgAlpha;
	var $PDFAXwarnings;
	var $MetadataRoot;
	var $OutputIntentRoot;
	var $InfoRoot;
	var $current_filename;
	var $parsers;
	var $current_parser;
	var $_obj_stack;
	var $_don_obj_stack;
	var $_current_obj_id;
	var $tpls;
	var $tpl;
	var $tplprefix;
	var $_res;

	var $pdf_version;
	var $noImageFile;
	var $lastblockbottommargin;
	var $baselineC;

	// mPDF 5.7.3  inline text-decoration parameters
	var $baselineSup;
	var $baselineSub;
	var $baselineS;
	var $subPos;
	var $subArrMB;
	var $ReqFontStyle;
	var $tableClipPath;

	var $fullImageHeight;

	var $inFixedPosBlock;  // Internal flag for position:fixed block
	var $fixedPosBlock;  // Buffer string for position:fixed block
	var $fixedPosBlockDepth;
	var $fixedPosBlockBBox;
	var $fixedPosBlockSave;
	var $maxPosL;
	var $maxPosR;
	var $loaded;

	var $extraFontSubsets;

	var $docTemplateStart;  // Internal flag for page (page no. -1) that docTemplate starts on

	var $time0;

	// Classes
	var $indic;
	var $barcode;

	var $SHYpatterns;
	var $loadedSHYpatterns;
	var $loadedSHYdictionary;
	var $SHYdictionary;
	var $SHYdictionaryWords;

	var $spanbgcolorarray;
	var $default_font;
	var $headerbuffer;
	var $lastblocklevelchange;
	var $nestedtablejustfinished;
	var $linebreakjustfinished;
	var $cell_border_dominance_L;
	var $cell_border_dominance_R;
	var $cell_border_dominance_T;
	var $cell_border_dominance_B;
	var $table_keep_together;
	var $plainCell_properties;
	var $shrin_k1;
	var $outerfilled;

	var $blockContext;
	var $floatDivs;

	var $patterns;
	var $pageBackgrounds;

	var $bodyBackgroundGradient;
	var $bodyBackgroundImage;
	var $bodyBackgroundColor;

	var $writingHTMLheader; // internal flag - used both for writing HTMLHeaders/Footers and FixedPos block
	var $writingHTMLfooter;

	var $angle;

	var $gradients;

	var $kwt_Reference;
	var $kwt_BMoutlines;
	var $kwt_toc;

	var $tbrot_BMoutlines;
	var $tbrot_toc;

	var $col_BMoutlines;
	var $col_toc;

	var $currentGraphId;
	var $graphs;

	var $floatbuffer;
	var $floatmargins;

	var $bullet;
	var $bulletarray;

	var $currentLang;
	var $default_lang;

	var $default_available_fonts;

	var $pageTemplate;
	var $docTemplate;
	var $docTemplateContinue;

	var $arabGlyphs;
	var $arabHex;
	var $persianGlyphs;
	var $persianHex;
	var $arabVowels;
	var $arabPrevLink;
	var $arabNextLink;

	var $formobjects; // array of Form Objects for WMF
	var $InlineProperties;
	var $InlineAnnots;
	var $InlineBDF; // mPDF 6 Bidirectional formatting
	var $InlineBDFctr; // mPDF 6

	var $ktAnnots;
	var $tbrot_Annots;
	var $kwt_Annots;
	var $columnAnnots;
	var $columnForms;

	var $PageAnnots;

	var $pageDim; // Keep track of page wxh for orientation changes - set in _beginpage, used in _putannots

	var $breakpoints;

	var $tableLevel;
	var $tbctr;
	var $innermostTableLevel;
	var $saveTableCounter;
	var $cellBorderBuffer;

	var $saveHTMLFooter_height;
	var $saveHTMLFooterE_height;

	var $firstPageBoxHeader;
	var $firstPageBoxHeaderEven;
	var $firstPageBoxFooter;
	var $firstPageBoxFooterEven;

	var $page_box;

	var $show_marks; // crop or cross marks
	var $basepathIsLocal;

	var $use_kwt;
	var $kwt;
	var $kwt_height;
	var $kwt_y0;
	var $kwt_x0;
	var $kwt_buffer;
	var $kwt_Links;
	var $kwt_moved;
	var $kwt_saved;

	var $PageNumSubstitutions;

	var $table_borders_separate;
	var $base_table_properties;
	var $borderstyles;

	var $blockjustfinished;

	var $orig_bMargin;
	var $orig_tMargin;
	var $orig_lMargin;
	var $orig_rMargin;
	var $orig_hMargin;
	var $orig_fMargin;

	var $pageHTMLheaders;
	var $pageHTMLfooters;

	var $saveHTMLHeader;
	var $saveHTMLFooter;

	var $HTMLheaderPageLinks;
	var $HTMLheaderPageAnnots;
	var $HTMLheaderPageForms;

	// See config_fonts.php for these next 5 values
	var $available_unifonts;
	var $sans_fonts;
	var $serif_fonts;
	var $mono_fonts;
	var $defaultSubsFont;

	// List of ALL available CJK fonts (incl. styles) (Adobe add-ons)  hw removed
	var $available_CJK_fonts;

	var $HTMLHeader;
	var $HTMLFooter;
	var $HTMLHeaderE;
	var $HTMLFooterE;
	var $bufferoutput;

	// CJK fonts
	var $Big5_widths;
	var $GB_widths;
	var $SJIS_widths;
	var $UHC_widths;

	// SetProtection
	var $encrypted; // whether document is protected
	var $Uvalue; // U entry in pdf document
	var $Ovalue; // O entry in pdf document
	var $Pvalue; // P entry in pdf document

	var $enc_obj_id; //encryption object id
	var $last_rc4_key; //last RC4 key encrypted (cached for optimisation)
	var $last_rc4_key_c; //last RC4 computed key

	var $encryption_key;

	var $padding; //used for encryption

	// Bookmark
	var $BMoutlines;
	var $OutlineRoot;

	// INDEX
	var $ColActive;
	var $Reference;
	var $CurrCol;
	var $NbCol;
	var $y0;   //Top ordinate of columns

	var $ColL;
	var $ColWidth;
	var $ColGap;

	// COLUMNS
	var $ColR;
	var $ChangeColumn;
	var $columnbuffer;
	var $ColDetails;
	var $columnLinks;
	var $colvAlign;

	// Substitutions
	var $substitute;  // Array of substitution strings e.g. <ttz>112</ttz>
	var $entsearch;  // Array of HTML entities (>ASCII 127) to substitute
	var $entsubstitute; // Array of substitution decimal unicode for the Hi entities

	// Default values if no style sheet offered	(cf. http://www.w3.org/TR/CSS21/sample.html)
	var $defaultCSS;
	var $lastoptionaltag; // Save current block item which HTML specifies optionsl endtag
	var $pageoutput;
	var $charset_in;
	var $blk;
	var $blklvl;
	var $ColumnAdjust;

	var $ws; // Word spacing

	var $HREF;
	var $pgwidth;
	var $fontlist;
	var $oldx;
	var $oldy;
	var $B;
	var $I;

	var $tdbegin;
	var $table;
	var $cell;
	var $col;
	var $row;

	var $divbegin;
	var $divwidth;
	var $divheight;
	var $spanbgcolor;

	// mPDF 6 Used for table cell (block-type) properties
	var $cellTextAlign;
	var $cellLineHeight;
	var $cellLineStackingStrategy;
	var $cellLineStackingShift;

	// mPDF 6  Lists
	var $listcounter;
	var $listlvl;
	var $listtype;
	var $listitem;

	var $pjustfinished;
	var $ignorefollowingspaces;
	var $SMALL;
	var $BIG;
	var $dash_on;
	var $dotted_on;

	var $textbuffer;
	var $currentfontstyle;
	var $currentfontfamily;
	var $currentfontsize;
	var $colorarray;
	var $bgcolorarray;
	var $internallink;
	var $enabledtags;

	var $lineheight;
	var $basepath;
	var $textparam;

	var $specialcontent;
	var $selectoption;
	var $objectbuffer;

	// Table Rotation
	var $table_rotate;
	var $tbrot_maxw;
	var $tbrot_maxh;
	var $tablebuffer;
	var $tbrot_align;
	var $tbrot_Links;

	var $keep_block_together; // Keep a Block from page-break-inside: avoid

	var $tbrot_y0;
	var $tbrot_x0;
	var $tbrot_w;
	var $tbrot_h;

	var $mb_enc;
	var $directionality;

	var $extgstates; // Used for alpha channel - Transparency (Watermark)
	var $mgl;
	var $mgt;
	var $mgr;
	var $mgb;

	var $tts;
	var $ttz;
	var $tta;

	// Best to alter the below variables using default stylesheet above
	var $page_break_after_avoid;
	var $margin_bottom_collapse;
	var $default_font_size; // in pts
	var $original_default_font_size; // used to save default sizes when using table default
	var $original_default_font;
	var $watermark_font;
	var $defaultAlign;

	// TABLE
	var $defaultTableAlign;
	var $tablethead;
	var $thead_font_weight;
	var $thead_font_style;
	var $thead_font_smCaps;
	var $thead_valign_default;
	var $thead_textalign_default;
	var $tabletfoot;
	var $tfoot_font_weight;
	var $tfoot_font_style;
	var $tfoot_font_smCaps;
	var $tfoot_valign_default;
	var $tfoot_textalign_default;

	var $trow_text_rotate;

	var $cellPaddingL;
	var $cellPaddingR;
	var $cellPaddingT;
	var $cellPaddingB;
	var $table_border_attr_set;
	var $table_border_css_set;

	var $shrin_k; // factor with which to shrink tables - used internally - do not change
	var $shrink_this_table_to_fit; // 0 or false to disable; value (if set) gives maximum factor to reduce fontsize
	var $MarginCorrection; // corrects for OddEven Margins
	var $margin_footer;
	var $margin_header;

	var $tabletheadjustfinished;
	var $usingCoreFont;
	var $charspacing;

	//Private properties FROM FPDF
	var $DisplayPreferences;
	var $flowingBlockAttr;
	var $page; //current page number
	var $n; //current object number
	var $offsets; //array of object offsets
	var $buffer; //buffer holding in-memory PDF
	var $pages; //array containing pages
	var $state; //current document state
	var $compress; //compression flag
	var $DefOrientation; //default orientation
	var $CurOrientation; //current orientation
	var $OrientationChanges; //array indicating orientation changes
	var $k; //scale factor (number of points in user unit)
	var $fwPt;
	var $fhPt; //dimensions of page format in points
	var $fw;
	var $fh; //dimensions of page format in user unit
	var $wPt;
	var $hPt; //current dimensions of page in points
	var $w;
	var $h; //current dimensions of page in user unit
	var $lMargin; //left margin
	var $tMargin; //top margin
	var $rMargin; //right margin
	var $bMargin; //page break margin
	var $cMarginL; //cell margin Left
	var $cMarginR; //cell margin Right
	var $cMarginT; //cell margin Left
	var $cMarginB; //cell margin Right
	var $DeflMargin; //Default left margin
	var $DefrMargin; //Default right margin
	var $x;
	var $y; //current position in user unit for cell positioning
	var $lasth; //height of last cell printed
	var $LineWidth; //line width in user unit
	var $CoreFonts; //array of standard font names
	var $fonts; //array of used fonts
	var $FontFiles; //array of font files
	var $images; //array of used images
	var $PageLinks; //array of links in pages
	var $links; //array of internal links
	var $FontFamily; //current font family
	var $FontStyle; //current font style
	var $CurrentFont; //current font info
	var $FontSizePt; //current font size in points
	var $FontSize; //current font size in user unit
	var $DrawColor; //commands for drawing color
	var $FillColor; //commands for filling color
	var $TextColor; //commands for text color
	var $ColorFlag; //indicates whether fill and text colors are different
	var $autoPageBreak; //automatic page breaking
	var $PageBreakTrigger; //threshold used to trigger page breaks
	var $InFooter; //flag set when processing footer

	var $InHTMLFooter;
	var $processingFooter; //flag set when processing footer - added for columns
	var $processingHeader; //flag set when processing header - added for columns
	var $ZoomMode; //zoom display mode
	var $LayoutMode; //layout display mode
	var $title; //title
	var $subject; //subject
	var $author; //author
	var $keywords; //keywords
	var $creator; //creator

	var $aliasNbPg; //alias for total number of pages
	var $aliasNbPgGp; //alias for total number of pages in page group

	//var $aliasNbPgHex;	// mPDF 6 deleted
	//var $aliasNbPgGpHex;	// mPDF 6 deleted

	var $ispre;
	var $outerblocktags;
	var $innerblocktags;

	// **********************************
	// **********************************
	// **********************************
	// **********************************
	// **********************************
	// **********************************
	// **********************************
	// **********************************
	// **********************************

	private $tag;

	public function __construct($mode = '', $format = 'A4', $default_font_size = 0, $default_font = '', $mgl = 15, $mgr = 15, $mgt = 16, $mgb = 16, $mgh = 9, $mgf = 9, $orientation = 'P')
	{
		/* -- BACKGROUNDS -- */
		if (!class_exists('grad', false)) {
			include(_MPDF_PATH . 'classes/grad.php');
		}
		if (empty($this->grad)) {
			$this->grad = new grad($this);
		}
		/* -- END BACKGROUNDS -- */
		/* -- FORMS -- */
		if (!class_exists('mpdfform', false)) {
			include(_MPDF_PATH . 'classes/mpdfform.php');
		}
		if (empty($this->mpdfform)) {
			$this->mpdfform = new mpdfform($this);
		}
		/* -- END FORMS -- */

		$this->time0 = microtime(true);
		//Some checks
		$this->_dochecks();

		$this->writingToC = false;
		$this->layers = array();
		$this->current_layer = 0;
		$this->open_layer_pane = false;

		$this->visibility = 'visible';

		//Initialization of properties
		$this->spotColors = array();
		$this->spotColorIDs = array();
		$this->tableBackgrounds = array();
		$this->uniqstr = '20110230'; // mPDF 5.7.2
		$this->kt_y00 = '';
		$this->kt_p00 = '';
		$this->iterationCounter = false;
		$this->BMPonly = array();
		$this->page = 0;
		$this->n = 2;
		$this->buffer = '';
		$this->objectbuffer = array();
		$this->pages = array();
		$this->OrientationChanges = array();
		$this->state = 0;
		$this->fonts = array();
		$this->FontFiles = array();
		$this->images = array();
		$this->links = array();
		$this->InFooter = false;
		$this->processingFooter = false;
		$this->processingHeader = false;
		$this->lasth = 0;
		$this->FontFamily = '';
		$this->FontStyle = '';
		$this->FontSizePt = 9;
		$this->U = false;
		// Small Caps
		$this->upperCase = array();
		$this->smCapsScale = 1;
		$this->smCapsStretch = 100;
		$this->margBuffer = 0;
		$this->inMeter = false;
		$this->decimal_offset = 0;

		$this->defTextColor = $this->TextColor = $this->SetTColor($this->ConvertColor(0), true);
		$this->defDrawColor = $this->DrawColor = $this->SetDColor($this->ConvertColor(0), true);
		$this->defFillColor = $this->FillColor = $this->SetFColor($this->ConvertColor(255), true);

		//SVG color names array
		//http://www.w3schools.com/css/css_colornames.asp
		$this->SVGcolors = array('antiquewhite' => '#FAEBD7', 'aqua' => '#00FFFF', 'aquamarine' => '#7FFFD4', 'beige' => '#F5F5DC', 'black' => '#000000',
			'blue' => '#0000FF', 'brown' => '#A52A2A', 'cadetblue' => '#5F9EA0', 'chocolate' => '#D2691E', 'cornflowerblue' => '#6495ED', 'crimson' => '#DC143C',
			'darkblue' => '#00008B', 'darkgoldenrod' => '#B8860B', 'darkgreen' => '#006400', 'darkmagenta' => '#8B008B', 'darkorange' => '#FF8C00',
			'darkred' => '#8B0000', 'darkseagreen' => '#8FBC8F', 'darkslategray' => '#2F4F4F', 'darkviolet' => '#9400D3', 'deepskyblue' => '#00BFFF',
			'dodgerblue' => '#1E90FF', 'firebrick' => '#B22222', 'forestgreen' => '#228B22', 'fuchsia' => '#FF00FF', 'gainsboro' => '#DCDCDC', 'gold' => '#FFD700',
			'gray' => '#808080', 'green' => '#008000', 'greenyellow' => '#ADFF2F', 'hotpink' => '#FF69B4', 'indigo' => '#4B0082', 'khaki' => '#F0E68C',
			'lavenderblush' => '#FFF0F5', 'lemonchiffon' => '#FFFACD', 'lightcoral' => '#F08080', 'lightgoldenrodyellow' => '#FAFAD2', 'lightgreen' => '#90EE90',
			'lightsalmon' => '#FFA07A', 'lightskyblue' => '#87CEFA', 'lightslategray' => '#778899', 'lightyellow' => '#FFFFE0', 'lime' => '#00FF00', 'limegreen' => '#32CD32',
			'magenta' => '#FF00FF', 'maroon' => '#800000', 'mediumaquamarine' => '#66CDAA', 'mediumorchid' => '#BA55D3', 'mediumseagreen' => '#3CB371',
			'mediumspringgreen' => '#00FA9A', 'mediumvioletred' => '#C71585', 'midnightblue' => '#191970', 'mintcream' => '#F5FFFA', 'moccasin' => '#FFE4B5', 'navy' => '#000080',
			'olive' => '#808000', 'orange' => '#FFA500', 'orchid' => '#DA70D6', 'palegreen' => '#98FB98',
			'palevioletred' => '#D87093', 'peachpuff' => '#FFDAB9', 'pink' => '#FFC0CB', 'powderblue' => '#B0E0E6', 'purple' => '#800080',
			'red' => '#FF0000', 'royalblue' => '#4169E1', 'salmon' => '#FA8072', 'seagreen' => '#2E8B57', 'sienna' => '#A0522D', 'silver' => '#C0C0C0', 'skyblue' => '#87CEEB',
			'slategray' => '#708090', 'springgreen' => '#00FF7F', 'steelblue' => '#4682B4', 'tan' => '#D2B48C', 'teal' => '#008080', 'thistle' => '#D8BFD8', 'turquoise' => '#40E0D0',
			'violetred' => '#D02090', 'white' => '#FFFFFF', 'yellow' => '#FFFF00',
			'aliceblue' => '#f0f8ff', 'azure' => '#f0ffff', 'bisque' => '#ffe4c4', 'blanchedalmond' => '#ffebcd', 'blueviolet' => '#8a2be2', 'burlywood' => '#deb887',
			'chartreuse' => '#7fff00', 'coral' => '#ff7f50', 'cornsilk' => '#fff8dc', 'cyan' => '#00ffff', 'darkcyan' => '#008b8b', 'darkgray' => '#a9a9a9',
			'darkgrey' => '#a9a9a9', 'darkkhaki' => '#bdb76b', 'darkolivegreen' => '#556b2f', 'darkorchid' => '#9932cc', 'darksalmon' => '#e9967a',
			'darkslateblue' => '#483d8b', 'darkslategrey' => '#2f4f4f', 'darkturquoise' => '#00ced1', 'deeppink' => '#ff1493', 'dimgray' => '#696969',
			'dimgrey' => '#696969', 'floralwhite' => '#fffaf0', 'ghostwhite' => '#f8f8ff', 'goldenrod' => '#daa520', 'grey' => '#808080', 'honeydew' => '#f0fff0',
			'indianred' => '#cd5c5c', 'ivory' => '#fffff0', 'lavender' => '#e6e6fa', 'lawngreen' => '#7cfc00', 'lightblue' => '#add8e6', 'lightcyan' => '#e0ffff',
			'lightgray' => '#d3d3d3', 'lightgrey' => '#d3d3d3', 'lightpink' => '#ffb6c1', 'lightseagreen' => '#20b2aa', 'lightslategrey' => '#778899',
			'lightsteelblue' => '#b0c4de', 'linen' => '#faf0e6', 'mediumblue' => '#0000cd', 'mediumpurple' => '#9370db', 'mediumslateblue' => '#7b68ee',
			'mediumturquoise' => '#48d1cc', 'mistyrose' => '#ffe4e1', 'navajowhite' => '#ffdead', 'oldlace' => '#fdf5e6', 'olivedrab' => '#6b8e23', 'orangered' => '#ff4500',
			'palegoldenrod' => '#eee8aa', 'paleturquoise' => '#afeeee', 'papayawhip' => '#ffefd5', 'peru' => '#cd853f', 'plum' => '#dda0dd', 'rosybrown' => '#bc8f8f',
			'saddlebrown' => '#8b4513', 'sandybrown' => '#f4a460', 'seashell' => '#fff5ee', 'slateblue' => '#6a5acd', 'slategrey' => '#708090', 'snow' => '#fffafa',
			'tomato' => '#ff6347', 'violet' => '#ee82ee', 'wheat' => '#f5deb3', 'whitesmoke' => '#f5f5f5', 'yellowgreen' => '#9acd32');

		// Uppercase alternatives (for Small Caps)
		if (empty($this->upperCase)) {
			@include(_MPDF_PATH . 'includes/upperCase.php');
		}
		$this->extrapagebreak = true; // mPDF 6 pagebreaktype

		$this->ColorFlag = false;
		$this->extgstates = array();

		$this->mb_enc = 'windows-1252';
		$this->directionality = 'ltr';
		$this->defaultAlign = 'L';
		$this->defaultTableAlign = 'L';

		$this->fixedPosBlockSave = array();
		$this->extraFontSubsets = 0;

		$this->SHYpatterns = array();
		$this->loadedSHYdictionary = false;
		$this->SHYdictionary = array();
		$this->SHYdictionaryWords = array();
		$this->blockContext = 1;
		$this->floatDivs = array();
		$this->DisplayPreferences = '';

		$this->patterns = array();  // Tiling patterns used for backgrounds
		$this->pageBackgrounds = array();
		$this->writingHTMLheader = false; // internal flag - used both for writing HTMLHeaders/Footers and FixedPos block
		$this->writingHTMLfooter = false; // internal flag - used both for writing HTMLHeaders/Footers and FixedPos block
		$this->gradients = array();

		$this->kwt_Reference = array();
		$this->kwt_BMoutlines = array();
		$this->kwt_toc = array();

		$this->tbrot_BMoutlines = array();
		$this->tbrot_toc = array();

		$this->col_BMoutlines = array();
		$this->col_toc = array();
		$this->graphs = array();

		$this->pgsIns = array();
		$this->PDFAXwarnings = array();
		$this->inlineDisplayOff = false;
		$this->lSpacingCSS = '';
		$this->wSpacingCSS = '';
		$this->fixedlSpacing = false;
		$this->minwSpacing = 0;


		$this->baselineC = 0.35; // Baseline for text
		// mPDF 5.7.3  inline text-decoration parameters
		$this->baselineSup = 0.5; // Sets default change in baseline for <sup> text as factor of preceeding fontsize
		// 0.35 has been recommended; 0.5 matches applications like MS Word
		$this->baselineSub = -0.2; // Sets default change in baseline for <sub> text as factor of preceeding fontsize
		$this->baselineS = 0.3;  // Sets default height for <strike> text as factor of fontsize
		$this->baselineO = 1.1;  // Sets default height for overline text as factor of fontsize

		$this->noImageFile = str_replace("\\", "/", dirname(__FILE__)) . '/includes/no_image.jpg';
		$this->subPos = 0;
		$this->normalLineheight = 1.3; // This should be overridden in config.php - but it is so important a default value is put here
		// These are intended as configuration variables, and should be set in config.php - which will override these values;
		// set here as failsafe as will cause an error if not defined
		$this->incrementFPR1 = 10;
		$this->incrementFPR2 = 10;
		$this->incrementFPR3 = 10;
		$this->incrementFPR4 = 10;

		$this->fullImageHeight = false;
		$this->floatbuffer = array();
		$this->floatmargins = array();
		$this->formobjects = array(); // array of Form Objects for WMF
		$this->InlineProperties = array();
		$this->InlineAnnots = array();
		$this->InlineBDF = array(); // mPDF 6
		$this->InlineBDFctr = 0; // mPDF 6
		$this->tbrot_Annots = array();
		$this->kwt_Annots = array();
		$this->columnAnnots = array();
		$this->pageDim = array();
		$this->breakpoints = array(); // used in columnbuffer
		$this->tableLevel = 0;
		$this->tbctr = array(); // counter for nested tables at each level
		$this->page_box = array();
		$this->show_marks = ''; // crop or cross marks
		$this->kwt = false;
		$this->kwt_height = 0;
		$this->kwt_y0 = 0;
		$this->kwt_x0 = 0;
		$this->kwt_buffer = array();
		$this->kwt_Links = array();
		$this->kwt_moved = false;
		$this->kwt_saved = false;
		$this->PageNumSubstitutions = array();
		$this->base_table_properties = array();
		$this->borderstyles = array('inset', 'groove', 'outset', 'ridge', 'dotted', 'dashed', 'solid', 'double');
		$this->tbrot_align = 'C';

		$this->pageHTMLheaders = array();
		$this->pageHTMLfooters = array();
		$this->HTMLheaderPageLinks = array();
		$this->HTMLheaderPageAnnots = array();

		$this->HTMLheaderPageForms = array();
		$this->columnForms = array();
		$this->tbrotForms = array();
		$this->useRC128encryption = false;
		$this->uniqid = '';

		$this->pageoutput = array();

		$this->bufferoutput = false;
		$this->encrypted = false;      //whether document is protected
		$this->BMoutlines = array();
		$this->ColActive = 0;          //Flag indicating that columns are on (the index is being processed)
		$this->Reference = array();    //Array containing the references
		$this->CurrCol = 0;               //Current column number
		$this->ColL = array(0);   // Array of Left pos of columns - absolute - needs Margin correction for Odd-Even
		$this->ColR = array(0);   // Array of Right pos of columns - absolute pos - needs Margin correction for Odd-Even
		$this->ChangeColumn = 0;
		$this->columnbuffer = array();
		$this->ColDetails = array();  // Keeps track of some column details
		$this->columnLinks = array();  // Cross references PageLinks
		$this->substitute = array();  // Array of substitution strings e.g. <ttz>112</ttz>
		$this->entsearch = array();  // Array of HTML entities (>ASCII 127) to substitute
		$this->entsubstitute = array(); // Array of substitution decimal unicode for the Hi entities
		$this->lastoptionaltag = '';
		$this->charset_in = '';
		$this->blk = array();
		$this->blklvl = 0;
		$this->tts = false;
		$this->ttz = false;
		$this->tta = false;
		$this->ispre = false;

		$this->checkSIP = false;
		$this->checkSMP = false;
		$this->checkCJK = false;

		$this->page_break_after_avoid = false;
		$this->margin_bottom_collapse = false;
		$this->tablethead = 0;
		$this->tabletfoot = 0;
		$this->table_border_attr_set = 0;
		$this->table_border_css_set = 0;
		$this->shrin_k = 1.0;
		$this->shrink_this_table_to_fit = 0;
		$this->MarginCorrection = 0;

		$this->tabletheadjustfinished = false;
		$this->usingCoreFont = false;
		$this->charspacing = 0;

		$this->autoPageBreak = true;

		require(_MPDF_PATH . 'config.php'); // config data

		$this->_setPageSize($format, $orientation);
		$this->DefOrientation = $orientation;

		$this->margin_header = $mgh;
		$this->margin_footer = $mgf;

		$bmargin = $mgb;

		$this->DeflMargin = $mgl;
		$this->DefrMargin = $mgr;

		$this->orig_tMargin = $mgt;
		$this->orig_bMargin = $bmargin;
		$this->orig_lMargin = $this->DeflMargin;
		$this->orig_rMargin = $this->DefrMargin;
		$this->orig_hMargin = $this->margin_header;
		$this->orig_fMargin = $this->margin_footer;

		if ($this->setAutoTopMargin == 'pad') {
			$mgt += $this->margin_header;
		}
		if ($this->setAutoBottomMargin == 'pad') {
			$mgb += $this->margin_footer;
		}
		$this->SetMargins($this->DeflMargin, $this->DefrMargin, $mgt); // sets l r t margin
		//Automatic page break
		$this->SetAutoPageBreak($this->autoPageBreak, $bmargin); // sets $this->bMargin & PageBreakTrigger

		$this->pgwidth = $this->w - $this->lMargin - $this->rMargin;

		//Interior cell margin (1 mm) ? not used
		$this->cMarginL = 1;
		$this->cMarginR = 1;
		//Line width (0.2 mm)
		$this->LineWidth = .567 / _MPDFK;

		//To make the function Footer() work - replaces {nb} with page number
		$this->AliasNbPages();
		$this->AliasNbPageGroups();

		//$this->aliasNbPgHex = '{nbHEXmarker}';	// mPDF 6 deleted
		//$this->aliasNbPgGpHex = '{nbpgHEXmarker}';	// mPDF 6 deleted
		//Enable all tags as default
		$this->DisableTags();
		//Full width display mode
		$this->SetDisplayMode(100); // fullwidth?		'fullpage'
		//Compression
		$this->SetCompression(true);
		//Set default display preferences
		$this->SetDisplayPreferences('');

		// Font data
		require(_MPDF_PATH . 'config_fonts.php');

		// check for a custom config file that can add/overwrite the default config
		if (defined('_MPDF_SYSTEM_TTFONTS_CONFIG') && file_exists(_MPDF_SYSTEM_TTFONTS_CONFIG)) {
			require(_MPDF_SYSTEM_TTFONTS_CONFIG);
		}

		// Available fonts
		$this->available_unifonts = array();
		foreach ($this->fontdata AS $f => $fs) {
			if (isset($fs['R']) && $fs['R']) {
				$this->available_unifonts[] = $f;
			}
			if (isset($fs['B']) && $fs['B']) {
				$this->available_unifonts[] = $f . 'B';
			}
			if (isset($fs['I']) && $fs['I']) {
				$this->available_unifonts[] = $f . 'I';
			}
			if (isset($fs['BI']) && $fs['BI']) {
				$this->available_unifonts[] = $f . 'BI';
			}
		}

		$this->default_available_fonts = $this->available_unifonts;

		$optcore = false;
		$onlyCoreFonts = false;
		if (preg_match('/([\-+])aCJK/i', $mode, $m)) {
			$mode = preg_replace('/([\-+])aCJK/i', '', $mode); // mPDF 6
			if ($m[1] == '+') {
				$this->useAdobeCJK = true;
			} else {
				$this->useAdobeCJK = false;
			}
		}

		if (strlen($mode) == 1) {
			if ($mode == 's') {
				$this->percentSubset = 100;
				$mode = '';
			} elseif ($mode == 'c') {
				$onlyCoreFonts = true;
				$mode = '';
			}
		} elseif (substr($mode, -2) == '-s') {
			$this->percentSubset = 100;
			$mode = substr($mode, 0, strlen($mode) - 2);
		} elseif (substr($mode, -2) == '-c') {
			$onlyCoreFonts = true;
			$mode = substr($mode, 0, strlen($mode) - 2);
		} elseif (substr($mode, -2) == '-x') {
			$optcore = true;
			$mode = substr($mode, 0, strlen($mode) - 2);
		}

		// Autodetect if mode is a language_country string (en-GB or en_GB or en)
		if ($mode && $mode != 'UTF-8') { // mPDF 6
			list ($coreSuitable, $mpdf_pdf_unifont) = GetLangOpts($mode, $this->useAdobeCJK, $this->fontdata);
			if ($coreSuitable && $optcore) {
				$onlyCoreFonts = true;
			}
			if ($mpdf_pdf_unifont) {  // mPDF 6
				$default_font = $mpdf_pdf_unifont;
			}
			$this->currentLang = $mode;
			$this->default_lang = $mode;
		}

		$this->onlyCoreFonts = $onlyCoreFonts;

		if ($this->onlyCoreFonts) {
			$this->setMBencoding('windows-1252'); // sets $this->mb_enc
		} else {
			$this->setMBencoding('UTF-8'); // sets $this->mb_enc
		}
		@mb_regex_encoding('UTF-8'); // required only for mb_ereg... and mb_split functions
		// Adobe CJK fonts
		$this->available_CJK_fonts = array('gb', 'big5', 'sjis', 'uhc', 'gbB', 'big5B', 'sjisB', 'uhcB', 'gbI', 'big5I', 'sjisI', 'uhcI',
			'gbBI', 'big5BI', 'sjisBI', 'uhcBI');


		//Standard fonts
		$this->CoreFonts = array('ccourier' => 'Courier', 'ccourierB' => 'Courier-Bold', 'ccourierI' => 'Courier-Oblique', 'ccourierBI' => 'Courier-BoldOblique',
			'chelvetica' => 'Helvetica', 'chelveticaB' => 'Helvetica-Bold', 'chelveticaI' => 'Helvetica-Oblique', 'chelveticaBI' => 'Helvetica-BoldOblique',
			'ctimes' => 'Times-Roman', 'ctimesB' => 'Times-Bold', 'ctimesI' => 'Times-Italic', 'ctimesBI' => 'Times-BoldItalic',
			'csymbol' => 'Symbol', 'czapfdingbats' => 'ZapfDingbats');
		$this->fontlist = array("ctimes", "ccourier", "chelvetica", "csymbol", "czapfdingbats");

		// Substitutions
		$this->setHiEntitySubstitutions();

		if ($this->onlyCoreFonts) {
			$this->useSubstitutions = true;
			$this->SetSubstitutions();
		} else {
			$this->useSubstitutions = false;
		}

		/* -- HTML-CSS -- */

		if (!class_exists('cssmgr', false)) {
			include(_MPDF_PATH . 'classes/cssmgr.php');
		}
		$this->cssmgr = new cssmgr($this);
		// mPDF 6
		if (file_exists(_MPDF_PATH . 'mpdf.css')) {
			$css = file_get_contents(_MPDF_PATH . 'mpdf.css');
			$this->cssmgr->ReadCSS('<style> ' . $css . ' </style>');
		}
		/* -- END HTML-CSS -- */

		if ($default_font == '') {
			if ($this->onlyCoreFonts) {
				if (in_array(strtolower($this->defaultCSS['BODY']['FONT-FAMILY']), $this->mono_fonts)) {
					$default_font = 'ccourier';
				} elseif (in_array(strtolower($this->defaultCSS['BODY']['FONT-FAMILY']), $this->sans_fonts)) {
					$default_font = 'chelvetica';
				} else {
					$default_font = 'ctimes';
				}
			} else {
				$default_font = $this->defaultCSS['BODY']['FONT-FAMILY'];
			}
		}
		if (!$default_font_size) {
			$mmsize = $this->ConvertSize($this->defaultCSS['BODY']['FONT-SIZE']);
			$default_font_size = $mmsize * (_MPDFK);
		}

		if ($default_font) {
			$this->SetDefaultFont($default_font);
		}
		if ($default_font_size) {
			$this->SetDefaultFontSize($default_font_size);
		}

		$this->SetLineHeight(); // lineheight is in mm

		$this->SetFColor($this->ConvertColor(255));
		$this->HREF = '';
		$this->oldy = -1;
		$this->B = 0;
		$this->I = 0;

		// mPDF 6  Lists
		$this->listlvl = 0;
		$this->listtype = array();
		$this->listitem = array();
		$this->listcounter = array();

		$this->tdbegin = false;
		$this->table = array();
		$this->cell = array();
		$this->col = -1;
		$this->row = -1;
		$this->cellBorderBuffer = array();

		$this->divbegin = false;
		// mPDF 6
		$this->cellTextAlign = '';
		$this->cellLineHeight = '';
		$this->cellLineStackingStrategy = '';
		$this->cellLineStackingShift = '';

		$this->divwidth = 0;
		$this->divheight = 0;
		$this->spanbgcolor = false;
		$this->spanborder = false;
		$this->spanborddet = array();

		$this->blockjustfinished = false;
		$this->ignorefollowingspaces = true; //in order to eliminate exceeding left-side spaces
		$this->dash_on = false;
		$this->dotted_on = false;
		$this->textshadow = '';

		$this->currentfontfamily = '';
		$this->currentfontsize = '';
		$this->currentfontstyle = '';
		$this->colorarray = ''; // mPDF 6
		$this->spanbgcolorarray = ''; // mPDF 6
		$this->textbuffer = array();
		$this->internallink = array();
		$this->basepath = "";

		$this->SetBasePath('');

		$this->textparam = array();

		$this->specialcontent = '';
		$this->selectoption = array();

		/* -- IMPORTS -- */

		$this->tpls = array();
		$this->tpl = 0;
		$this->tplprefix = "/TPL";
		$this->res = array();
		if ($this->enableImports) {
			$this->SetImportUse();
		}
		/* -- END IMPORTS -- */

		if ($this->progressBar) {
			$this->StartProgressBarOutput($this->progressBar);
		} // *PROGRESS-BAR*

		$this->tag = new Tag($this);
	}

	function _setPageSize($format, &$orientation)
	{
		//Page format
		if (is_string($format)) {
			if ($format == '') {
				$format = 'A4';
			}
			$pfo = 'P';
			if (preg_match('/([0-9a-zA-Z]*)-L/i', $format, $m)) { // e.g. A4-L = A4 landscape
				$format = $m[1];
				$pfo = 'L';
			}
			$format = $this->_getPageFormat($format);
			if (!$format) {
				throw new MpdfException('Unknown page format: ' . $format);
			} else {
				$orientation = $pfo;
			}

			$this->fwPt = $format[0];
			$this->fhPt = $format[1];
		} else {
			if (!$format[0] || !$format[1]) {
				throw new MpdfException('Invalid page format: ' . $format[0] . ' ' . $format[1]);
			}
			$this->fwPt = $format[0] * _MPDFK;
			$this->fhPt = $format[1] * _MPDFK;
		}
		$this->fw = $this->fwPt / _MPDFK;
		$this->fh = $this->fhPt / _MPDFK;
		//Page orientation
		$orientation = strtolower($orientation);
		if ($orientation == 'p' or $orientation == 'portrait') {
			$orientation = 'P';
			$this->wPt = $this->fwPt;
			$this->hPt = $this->fhPt;
		} elseif ($orientation == 'l' or $orientation == 'landscape') {
			$orientation = 'L';
			$this->wPt = $this->fhPt;
			$this->hPt = $this->fwPt;
		} else
			throw new MpdfException('Incorrect orientation: ' . $orientation);
		$this->CurOrientation = $orientation;

		$this->w = $this->wPt / _MPDFK;
		$this->h = $this->hPt / _MPDFK;
	}

	function _getPageFormat($format)
	{
		switch (strtoupper($format)) {
			case '4A0': {
					$format = array(4767.87, 6740.79);
					break;
				}
			case '2A0': {
					$format = array(3370.39, 4767.87);
					break;
				}
			case 'A0': {
					$format = array(2383.94, 3370.39);
					break;
				}
			case 'A1': {
					$format = array(1683.78, 2383.94);
					break;
				}
			case 'A2': {
					$format = array(1190.55, 1683.78);
					break;
				}
			case 'A3': {
					$format = array(841.89, 1190.55);
					break;
				}
			case 'A4': {
					$format = array(595.28, 841.89);
					break;
				}
			case 'A5': {
					$format = array(419.53, 595.28);
					break;
				}
			case 'A6': {
					$format = array(297.64, 419.53);
					break;
				}
			case 'A7': {
					$format = array(209.76, 297.64);
					break;
				}
			case 'A8': {
					$format = array(147.40, 209.76);
					break;
				}
			case 'A9': {
					$format = array(104.88, 147.40);
					break;
				}
			case 'A10': {
					$format = array(73.70, 104.88);
					break;
				}
			case 'B0': {
					$format = array(2834.65, 4008.19);
					break;
				}
			case 'B1': {
					$format = array(2004.09, 2834.65);
					break;
				}
			case 'B2': {
					$format = array(1417.32, 2004.09);
					break;
				}
			case 'B3': {
					$format = array(1000.63, 1417.32);
					break;
				}
			case 'B4': {
					$format = array(708.66, 1000.63);
					break;
				}
			case 'B5': {
					$format = array(498.90, 708.66);
					break;
				}
			case 'B6': {
					$format = array(354.33, 498.90);
					break;
				}
			case 'B7': {
					$format = array(249.45, 354.33);
					break;
				}
			case 'B8': {
					$format = array(175.75, 249.45);
					break;
				}
			case 'B9': {
					$format = array(124.72, 175.75);
					break;
				}
			case 'B10': {
					$format = array(87.87, 124.72);
					break;
				}
			case 'C0': {
					$format = array(2599.37, 3676.54);
					break;
				}
			case 'C1': {
					$format = array(1836.85, 2599.37);
					break;
				}
			case 'C2': {
					$format = array(1298.27, 1836.85);
					break;
				}
			case 'C3': {
					$format = array(918.43, 1298.27);
					break;
				}
			case 'C4': {
					$format = array(649.13, 918.43);
					break;
				}
			case 'C5': {
					$format = array(459.21, 649.13);
					break;
				}
			case 'C6': {
					$format = array(323.15, 459.21);
					break;
				}
			case 'C7': {
					$format = array(229.61, 323.15);
					break;
				}
			case 'C8': {
					$format = array(161.57, 229.61);
					break;
				}
			case 'C9': {
					$format = array(113.39, 161.57);
					break;
				}
			case 'C10': {
					$format = array(79.37, 113.39);
					break;
				}
			case 'RA0': {
					$format = array(2437.80, 3458.27);
					break;
				}
			case 'RA1': {
					$format = array(1729.13, 2437.80);
					break;
				}
			case 'RA2': {
					$format = array(1218.90, 1729.13);
					break;
				}
			case 'RA3': {
					$format = array(864.57, 1218.90);
					break;
				}
			case 'RA4': {
					$format = array(609.45, 864.57);
					break;
				}
			case 'SRA0': {
					$format = array(2551.18, 3628.35);
					break;
				}
			case 'SRA1': {
					$format = array(1814.17, 2551.18);
					break;
				}
			case 'SRA2': {
					$format = array(1275.59, 1814.17);
					break;
				}
			case 'SRA3': {
					$format = array(907.09, 1275.59);
					break;
				}
			case 'SRA4': {
					$format = array(637.80, 907.09);
					break;
				}
			case 'LETTER': {
					$format = array(612.00, 792.00);
					break;
				}
			case 'LEGAL': {
					$format = array(612.00, 1008.00);
					break;
				}
			case 'LEDGER': {
					$format = array(1224.00, 792.00);
					break;
				}
			case 'TABLOID': {
					$format = array(792.00, 1224.00);
					break;
				}
			case 'EXECUTIVE': {
					$format = array(521.86, 756.00);
					break;
				}
			case 'FOLIO': {
					$format = array(612.00, 936.00);
					break;
				}
			case 'B': {
					$format = array(362.83, 561.26);
					break;
				}  //	'B' format paperback size 128x198mm
			case 'A': {
					$format = array(314.65, 504.57);
					break;
				}  //	'A' format paperback size 111x178mm
			case 'DEMY': {
					$format = array(382.68, 612.28);
					break;
				}  //	'Demy' format paperback size 135x216mm
			case 'ROYAL': {
					$format = array(433.70, 663.30);
					break;
				} //	'Royal' format paperback size 153x234mm
			default: {
					$format = array(595.28, 841.89);
					break;
				}
		}
		return $format;
	}

	/* -- PROGRESS-BAR -- */

	function StartProgressBarOutput($mode = 1)
	{
		// must be relative path, or URI (not a file system path)
		if (!defined('_MPDF_URI')) {
			$this->progressBar = false;
			if ($this->debug) {
				throw new MpdfException("You need to define _MPDF_URI to use the progress bar!");
			} else
				return false;
		}
		$this->progressBar = $mode;
		if ($this->progbar_altHTML) {
			echo $this->progbar_altHTML;
		} else {
			echo '<html>
	<head>
	<title>mPDF File Progress</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="' . _MPDF_URI . 'progbar.css" />
		</head>
	<body>
	<div class="main">
		<div class="heading">' . $this->progbar_heading . '</div>
		<div class="demo">
	   ';
			if ($this->progressBar == 2) {
				echo '		<table width="100%"><tr><td style="width: 50%;">
			<span class="barheading">Writing HTML code</span> <br/>

			<div class="progressBar">
			<div id="element1"  class="innerBar">&nbsp;</div>
			</div>
			<span class="code" id="box1"></span>
			</td><td style="width: 50%;">
			<span class="barheading">Autosizing elements</span> <br/>
			<div class="progressBar">
			<div id="element4"  class="innerBar">&nbsp;</div>
			</div>
			<span class="code" id="box4"></span>
			<br/><br/>
			<span class="barheading">Writing Tables</span> <br/>
			<div class="progressBar">
			<div id="element7"  class="innerBar">&nbsp;</div>
			</div>
			<span class="code" id="box7"></span>
			</td></tr>
			<tr><td><br /><br /></td><td></td></tr>
			<tr><td style="width: 50%;">
	';
			}
			echo '			<span class="barheading">Writing PDF file</span> <br/>
			<div class="progressBar">
			<div id="element2"  class="innerBar">&nbsp;</div>
			</div>
			<span class="code" id="box2"></span>
	   ';
			if ($this->progressBar == 2) {
				echo '
			</td><td style="width: 50%;">
			<span class="barheading">Memory usage</span> <br/>
			<div class="progressBar">
			<div id="element5"  class="innerBar">&nbsp;</div>
			</div>
			<span id="box5">0</span> ' . ini_get("memory_limit") . '<br />
			<br/><br/>
			<span class="barheading">Memory usage (peak)</span> <br/>
			<div class="progressBar">
			<div id="element6"  class="innerBar">&nbsp;</div>
			</div>
			<span id="box6">0</span> ' . ini_get("memory_limit") . '<br />
			</td></tr>
			</table>
	   ';
			}
			echo '			<br/><br/>
		<span id="box3"></span>

		</div>
	   ';
		}
		ob_flush();
		flush();
	}

	function UpdateProgressBar($el, $val, $txt = '')
	{
		// $val should be a string - 5 = actual value, +15 = increment

		if ($this->progressBar < 2) {
			if ($el > 3) {
				return;
			} elseif ($el == 1) {
				$el = 2;
			}
		}
		echo '<script type="text/javascript">';
		if ($val) {
			echo ' document.getElementById(\'element' . $el . '\').style.width=\'' . $val . '%\'; ';
		}
		if ($txt) {
			echo ' document.getElementById(\'box' . $el . '\').innerHTML=\'' . $txt . '\'; ';
		}
		if ($this->progressBar == 2) {
			$m = round(memory_get_usage(true) / 1048576);
			$m2 = round(memory_get_peak_usage(true) / 1048576);
			$mem = $m * 100 / (ini_get("memory_limit") + 0);
			$mem2 = $m2 * 100 / (ini_get("memory_limit") + 0);
			echo ' document.getElementById(\'element5\').style.width=\'' . $mem . '%\'; ';
			echo ' document.getElementById(\'element6\').style.width=\'' . $mem2 . '%\'; ';
			echo ' document.getElementById(\'box5\').innerHTML=\'' . $m . 'MB / \'; ';
			echo ' document.getElementById(\'box6\').innerHTML=\'' . $m2 . 'MB / \'; ';
		}
		echo '</script>' . "\n";
		ob_flush();
		flush();
	}

	/* -- END PROGRESS-BAR -- */

	function RestrictUnicodeFonts($res)
	{
		// $res = array of (Unicode) fonts to restrict to: e.g. norasi|norasiB - language specific
		if (count($res)) { // Leave full list of available fonts if passed blank array
			$this->available_unifonts = $res;
		} else {
			$this->available_unifonts = $this->default_available_fonts;
		}
		if (count($this->available_unifonts) == 0) {
			$this->available_unifonts[] = $this->default_available_fonts[0];
		}
		$this->available_unifonts = array_values($this->available_unifonts);
	}

	function setMBencoding($enc)
	{
		if ($this->mb_enc != $enc) {
			$this->mb_enc = $enc;
			mb_internal_encoding($this->mb_enc);
		}
	}

	function SetMargins($left, $right, $top)
	{
		//Set left, top and right margins
		$this->lMargin = $left;
		$this->rMargin = $right;
		$this->tMargin = $top;
	}

	function ResetMargins()
	{
		//ReSet left, top margins
		if (($this->forcePortraitHeaders || $this->forcePortraitMargins) && $this->DefOrientation == 'P' && $this->CurOrientation == 'L') {
			if (($this->mirrorMargins) && (($this->page) % 2 == 0)) { // EVEN
				$this->tMargin = $this->orig_rMargin;
				$this->bMargin = $this->orig_lMargin;
			} else { // ODD	// OR NOT MIRRORING MARGINS/FOOTERS
				$this->tMargin = $this->orig_lMargin;
				$this->bMargin = $this->orig_rMargin;
			}
			$this->lMargin = $this->DeflMargin;
			$this->rMargin = $this->DefrMargin;
			$this->MarginCorrection = 0;
			$this->PageBreakTrigger = $this->h - $this->bMargin;
		} elseif (($this->mirrorMargins) && (($this->page) % 2 == 0)) { // EVEN
			$this->lMargin = $this->DefrMargin;
			$this->rMargin = $this->DeflMargin;
			$this->MarginCorrection = $this->DefrMargin - $this->DeflMargin;
		} else { // ODD	// OR NOT MIRRORING MARGINS/FOOTERS
			$this->lMargin = $this->DeflMargin;
			$this->rMargin = $this->DefrMargin;
			if ($this->mirrorMargins) {
				$this->MarginCorrection = $this->DeflMargin - $this->DefrMargin;
			}
		}
		$this->x = $this->lMargin;
	}

	function SetLeftMargin($margin)
	{
		//Set left margin
		$this->lMargin = $margin;
		if ($this->page > 0 and $this->x < $margin)
			$this->x = $margin;
	}

	function SetTopMargin($margin)
	{
		//Set top margin
		$this->tMargin = $margin;
	}

	function SetRightMargin($margin)
	{
		//Set right margin
		$this->rMargin = $margin;
	}

	function SetAutoPageBreak($auto, $margin = 0)
	{
		//Set auto page break mode and triggering margin
		$this->autoPageBreak = $auto;
		$this->bMargin = $margin;
		$this->PageBreakTrigger = $this->h - $margin;
	}

	function SetDisplayMode($zoom, $layout = 'continuous')
	{
		//Set display mode in viewer
		if ($zoom == 'fullpage' or $zoom == 'fullwidth' or $zoom == 'real' or $zoom == 'default' or ! is_string($zoom))
			$this->ZoomMode = $zoom;
		else
			throw new MpdfException('Incorrect zoom display mode: ' . $zoom);
		if ($layout == 'single' or $layout == 'continuous' or $layout == 'two' or $layout == 'twoleft' or $layout == 'tworight' or $layout == 'default')
			$this->LayoutMode = $layout;
		else
			throw new MpdfException('Incorrect layout display mode: ' . $layout);
	}

	function SetCompression($compress)
	{
		//Set page compression
		if (function_exists('gzcompress'))
			$this->compress = $compress;
		else
			$this->compress = false;
	}

	function SetTitle($title)
	{
		//Title of document // Arrives as UTF-8
		$this->title = $title;
	}

	function SetSubject($subject)
	{
		//Subject of document
		$this->subject = $subject;
	}

	function SetAuthor($author)
	{
		//Author of document
		$this->author = $author;
	}

	function SetKeywords($keywords)
	{
		//Keywords of document
		$this->keywords = $keywords;
	}

	function SetCreator($creator)
	{
		//Creator of document
		$this->creator = $creator;
	}

	function SetAnchor2Bookmark($x)
	{
		$this->anchor2Bookmark = $x;
	}

	function AliasNbPages($alias = '{nb}')
	{
		//Define an alias for total number of pages
		$this->aliasNbPg = $alias;
	}

	function AliasNbPageGroups($alias = '{nbpg}')
	{
		//Define an alias for total number of pages in a group
		$this->aliasNbPgGp = $alias;
	}

	function SetAlpha($alpha, $bm = 'Normal', $return = false, $mode = 'B')
	{
		// alpha: real value from 0 (transparent) to 1 (opaque)
		// bm:    blend mode, one of the following:
		//          Normal, Multiply, Screen, Overlay, Darken, Lighten, ColorDodge, ColorBurn,
		//          HardLight, SoftLight, Difference, Exclusion, Hue, Saturation, Color, Luminosity
		// set alpha for stroking (CA) and non-stroking (ca) operations
		// mode determines F (fill) S (stroke) B (both)
		if (($this->PDFA || $this->PDFX) && $alpha != 1) {
			if (($this->PDFA && !$this->PDFAauto) || ($this->PDFX && !$this->PDFXauto)) {
				$this->PDFAXwarnings[] = "Image opacity must be 100% (Opacity changed to 100%)";
			}
			$alpha = 1;
		}
		$a = array('BM' => '/' . $bm);
		if ($mode == 'F' || $mode == 'B')
			$a['ca'] = $alpha; // mPDF 5.7.2
		if ($mode == 'S' || $mode == 'B')
			$a['CA'] = $alpha; // mPDF 5.7.2
		$gs = $this->AddExtGState($a);
		if ($return) {
			return sprintf('/GS%d gs', $gs);
		} else {
			$this->_out(sprintf('/GS%d gs', $gs));
		}
	}

	function AddExtGState($parms)
	{
		$n = count($this->extgstates);
		// check if graphics state already exists
		for ($i = 1; $i <= $n; $i++) {
			if (count($this->extgstates[$i]['parms']) == count($parms)) {
				$same = true;
				foreach ($this->extgstates[$i]['parms'] AS $k => $v) {
					if (!isset($parms[$k]) || $parms[$k] != $v) {
						$same = false;
						break;
					}
				}
				if ($same) {
					return $i;
				}
			}
		}
		$n++;
		$this->extgstates[$n]['parms'] = $parms;
		return $n;
	}

	function SetVisibility($v)
	{
		if (($this->PDFA || $this->PDFX) && $this->visibility != 'visible') {
			$this->PDFAXwarnings[] = "Cannot set visibility to anything other than full when using PDFA or PDFX";
			return '';
		} elseif (!$this->PDFA && !$this->PDFX)
			$this->pdf_version = '1.5';
		if ($this->visibility != 'visible') {
			$this->_out('EMC');
			$this->hasOC = intval($this->hasOC);
		}
		if ($v == 'printonly') {
			$this->_out('/OC /OC1 BDC');
			$this->hasOC = ($this->hasOC | 1);
		} elseif ($v == 'screenonly') {
			$this->_out('/OC /OC2 BDC');
			$this->hasOC = ($this->hasOC | 2);
		} elseif ($v == 'hidden') {
			$this->_out('/OC /OC3 BDC');
			$this->hasOC = ($this->hasOC | 4);
		} elseif ($v != 'visible')
			throw new MpdfException('Incorrect visibility: ' . $v);
		$this->visibility = $v;
	}

	function Open()
	{
		//Begin document
		if ($this->state == 0) {
			// Was is function _begindoc()
			// Start document
			$this->state = 1;
			$this->_out('%PDF-' . $this->pdf_version);
			$this->_out('%' . chr(226) . chr(227) . chr(207) . chr(211)); // 4 chars > 128 to show binary file
		}
	}

	// +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	// DEPRACATED but included for backwards compatability
	// Depracated - can use AddPage for all
	function AddPages($a = '', $b = '', $c = '', $d = '', $e = '', $f = '', $g = '', $h = '', $i = '', $j = '', $k = '', $l = '', $m = '', $n = '', $o = '', $p = 0, $q = 0, $r = 0, $s = 0, $t = '', $u = '')
	{
		throw new MpdfException('function AddPages is depracated as of mPDF 6. Please use AddPage or HTML code methods instead.');
	}

	function startPageNums()
	{
		throw new MpdfException('function startPageNums is depracated as of mPDF 6.');
	}

	function setUnvalidatedText($a = '', $b = -1)
	{
		throw new MpdfException('function setUnvalidatedText is depracated as of mPDF 6. Please use SetWatermarkText instead.');
	}

	function SetAutoFont($a)
	{
		throw new MpdfException('function SetAutoFont is depracated as of mPDF 6. Please use autoScriptToLang instead. See config.php');
	}

	function Reference($a)
	{
		throw new MpdfException('function Reference is depracated as of mPDF 6. Please use IndexEntry instead.');
	}

	function ReferenceSee($a, $b)
	{
		throw new MpdfException('function ReferenceSee is depracated as of mPDF 6. Please use IndexEntrySee instead.');
	}

	function CreateReference($a = 1, $b = '', $c = '', $d = 3, $e = 1, $f = '', $g = 5, $h = '', $i = '', $j = false)
	{
		throw new MpdfException('function CreateReference is depracated as of mPDF 6. Please use InsertIndex instead.');
	}

	function CreateIndex($a = 1, $b = '', $c = '', $d = 3, $e = 1, $f = '', $g = 5, $h = '', $i = '', $j = false)
	{
		throw new MpdfException('function CreateIndex is depracated as of mPDF 6. Please use InsertIndex instead.');
	}

	// +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

	function Close()
	{
		// Check old Aliases - now depracated mPDF 6
		if (isset($this->UnvalidatedText)) {
			throw new MpdfException('$mpdf->UnvalidatedText is depracated as of mPDF 6. Please use $mpdf->watermarkText  instead.');
		}
		if (isset($this->TopicIsUnvalidated)) {
			throw new MpdfException('$mpdf->TopicIsUnvalidated is depracated as of mPDF 6. Please use $mpdf->showWatermarkText instead.');
		}
		if (isset($this->AliasNbPg)) {
			throw new MpdfException('$mpdf->AliasNbPg is depracated as of mPDF 6. Please use $mpdf->aliasNbPg instead.');
		}
		if (isset($this->AliasNbPgGp)) {
			throw new MpdfException('$mpdf->AliasNbPgGp is depracated as of mPDF 6. Please use $mpdf->aliasNbPgGp instead.');
		}
		if (isset($this->BiDirectional)) {
			throw new MpdfException('$mpdf->BiDirectional is depracated as of mPDF 6. Please use $mpdf->biDirectional instead.');
		}
		if (isset($this->Anchor2Bookmark)) {
			throw new MpdfException('$mpdf->Anchor2Bookmark is depracated as of mPDF 6. Please use $mpdf->anchor2Bookmark instead.');
		}
		if (isset($this->KeepColumns)) {
			throw new MpdfException('$mpdf->KeepColumns is depracated as of mPDF 6. Please use $mpdf->keepColumns instead.');
		}
		if (isset($this->useOddEven)) {
			throw new MpdfException('$mpdf->useOddEven is depracated as of mPDF 6. Please use $mpdf->mirrorMargins instead.');
		}
		if (isset($this->useSubstitutionsMB)) {
			throw new MpdfException('$mpdf->useSubstitutionsMB is depracated as of mPDF 6. Please use $mpdf->useSubstitutions instead.');
		}
		if (isset($this->useLang)) {
			throw new MpdfException('$mpdf->useLang is depracated as of mPDF 6. Please use $mpdf->autoLangToFont instead.');
		}
		if (isset($this->useAutoFont)) {
			throw new MpdfException('$mpdf->useAutoFont is depracated. Please use $mpdf->autoScriptToLang instead.');
		}

		if ($this->progressBar) {
			$this->UpdateProgressBar(2, '2', 'Closing last page');
		} // *PROGRESS-BAR*
		//Terminate document
		if ($this->state == 3)
			return;
		if ($this->page == 0)
			$this->AddPage($this->CurOrientation);
		if (count($this->cellBorderBuffer)) {
			$this->printcellbuffer();
		} // *TABLES*
		if ($this->tablebuffer) {
			$this->printtablebuffer();
		} // *TABLES*
		/* -- COLUMNS -- */

		if ($this->ColActive) {
			$this->SetColumns(0);
			$this->ColActive = 0;
			if (count($this->columnbuffer)) {
				$this->printcolumnbuffer();
			}
		}
		/* -- END COLUMNS -- */

		// BODY Backgrounds
		$s = '';

		$s .= $this->PrintBodyBackgrounds();

		$s .= $this->PrintPageBackgrounds();
		$this->pages[$this->page] = preg_replace('/(___BACKGROUND___PATTERNS' . $this->uniqstr . ')/', "\n" . $s . "\n" . '\\1', $this->pages[$this->page]);
		$this->pageBackgrounds = array();

		if ($this->visibility != 'visible')
			$this->SetVisibility('visible');
		$this->EndLayer();

		if (!$this->tocontents || !$this->tocontents->TOCmark) { //Page footer
			$this->InFooter = true;
			$this->Footer();
			$this->InFooter = false;
		}
		if ($this->tocontents && ($this->tocontents->TOCmark || count($this->tocontents->m_TOC))) {
			$this->tocontents->insertTOC();
		} // *TOC*
		//Close page
		$this->_endpage();

		//Close document
		$this->_enddoc();
	}

	/* -- BACKGROUNDS -- */

	function _resizeBackgroundImage($imw, $imh, $cw, $ch, $resize = 0, $repx, $repy, $pba = array(), $size = array())
	{
		// pba is background positioning area (from CSS background-origin) may not always be set [x,y,w,h]
		// size is from CSS3 background-size - takes precendence over old resize
		//	$w - absolute length or % or auto or cover | contain
		//	$h - absolute length or % or auto or cover | contain
		if (isset($pba['w']))
			$cw = $pba['w'];
		if (isset($pba['h']))
			$ch = $pba['h'];

		$cw = $cw * _MPDFK;
		$ch = $ch * _MPDFK;
		if (empty($size) && !$resize) {
			return array($imw, $imh, $repx, $repy);
		}

		if (isset($size['w']) && $size['w']) {
			if ($size['w'] == 'contain') {
				// Scale the image, while preserving its intrinsic aspect ratio (if any), to the largest size such that both its width and its height can fit inside the background positioning area.
				// Same as resize==3
				$h = $imh * $cw / $imw;
				$w = $cw;
				if ($h > $ch) {
					$w = $w * $ch / $h;
					$h = $ch;
				}
			} elseif ($size['w'] == 'cover') {
				// Scale the image, while preserving its intrinsic aspect ratio (if any), to the smallest size such that both its width and its height can completely cover the background positioning area.
				$h = $imh * $cw / $imw;
				$w = $cw;
				if ($h < $ch) {
					$w = $w * $h / $ch;
					$h = $ch;
				}
			} else {
				if (stristr($size['w'], '%')) {
					$size['w'] += 0;
					$size['w'] /= 100;
					$size['w'] = ($cw * $size['w']);
				}
				if (stristr($size['h'], '%')) {
					$size['h'] += 0;
					$size['h'] /= 100;
					$size['h'] = ($ch * $size['h']);
				}
				if ($size['w'] == 'auto' && $size['h'] == 'auto') {
					$w = $imw;
					$h = $imh;
				} elseif ($size['w'] == 'auto' && $size['h'] != 'auto') {
					$w = $imw * $size['h'] / $imh;
					$h = $size['h'];
				} elseif ($size['w'] != 'auto' && $size['h'] == 'auto') {
					$h = $imh * $size['w'] / $imw;
					$w = $size['w'];
				} else {
					$w = $size['w'];
					$h = $size['h'];
				}
			}
			return array($w, $h, $repx, $repy);
		} elseif ($resize == 1 && $imw > $cw) {
			$h = $imh * $cw / $imw;
			return array($cw, $h, $repx, $repy);
		} elseif ($resize == 2 && $imh > $ch) {
			$w = $imw * $ch / $imh;
			return array($w, $ch, $repx, $repy);
		} elseif ($resize == 3) {
			$w = $imw;
			$h = $imh;
			if ($w > $cw) {
				$h = $h * $cw / $w;
				$w = $cw;
			}
			if ($h > $ch) {
				$w = $w * $ch / $h;
				$h = $ch;
			}
			return array($w, $h, $repx, $repy);
		} elseif ($resize == 4) {
			$h = $imh * $cw / $imw;
			return array($cw, $h, $repx, $repy);
		} elseif ($resize == 5) {
			$w = $imw * $ch / $imh;
			return array($w, $ch, $repx, $repy);
		} elseif ($resize == 6) {
			return array($cw, $ch, $repx, $repy);
		}
		return array($imw, $imh, $repx, $repy);
	}

	function SetBackground(&$properties, &$maxwidth)
	{
		if (isset($properties['BACKGROUND-ORIGIN']) && ($properties['BACKGROUND-ORIGIN'] == 'border-box' || $properties['BACKGROUND-ORIGIN'] == 'content-box')) {
			$origin = $properties['BACKGROUND-ORIGIN'];
		} else {
			$origin = 'padding-box';
		}
		if (isset($properties['BACKGROUND-SIZE'])) {
			if (stristr($properties['BACKGROUND-SIZE'], 'contain')) {
				$bsw = $bsh = 'contain';
			} elseif (stristr($properties['BACKGROUND-SIZE'], 'cover')) {
				$bsw = $bsh = 'cover';
			} else {
				$bsw = $bsh = 'auto';
				$sz = preg_split('/\s+/', trim($properties['BACKGROUND-SIZE']));
				if (count($sz) == 2) {
					$bsw = $sz[0];
					$bsh = $sz[1];
				} else {
					$bsw = $sz[0];
				}
				if (!stristr($bsw, '%') && !stristr($bsw, 'auto')) {
					$bsw = $this->ConvertSize($bsw, $maxwidth, $this->FontSize);
				}
				if (!stristr($bsh, '%') && !stristr($bsh, 'auto')) {
					$bsh = $this->ConvertSize($bsh, $maxwidth, $this->FontSize);
				}
			}
			$size = array('w' => $bsw, 'h' => $bsh);
		} else {
			$size = false;
		} // mPDF 6
		if (preg_match('/(-moz-)*(repeating-)*(linear|radial)-gradient/', $properties['BACKGROUND-IMAGE'])) {
			return array('gradient' => $properties['BACKGROUND-IMAGE'], 'origin' => $origin, 'size' => $size);
		} else {
			$file = $properties['BACKGROUND-IMAGE'];
			$sizesarray = $this->Image($file, 0, 0, 0, 0, '', '', false, false, false, false, true);
			if (isset($sizesarray['IMAGE_ID'])) {
				$image_id = $sizesarray['IMAGE_ID'];
				$orig_w = $sizesarray['WIDTH'] * _MPDFK;  // in user units i.e. mm
				$orig_h = $sizesarray['HEIGHT'] * _MPDFK;  // (using $this->img_dpi)
				if (isset($properties['BACKGROUND-IMAGE-RESOLUTION'])) {
					if (preg_match('/from-image/i', $properties['BACKGROUND-IMAGE-RESOLUTION']) && isset($sizesarray['set-dpi']) && $sizesarray['set-dpi'] > 0) {
						$orig_w *= $this->img_dpi / $sizesarray['set-dpi'];
						$orig_h *= $this->img_dpi / $sizesarray['set-dpi'];
					} elseif (preg_match('/(\d+)dpi/i', $properties['BACKGROUND-IMAGE-RESOLUTION'], $m)) {
						$dpi = $m[1];
						if ($dpi > 0) {
							$orig_w *= $this->img_dpi / $dpi;
							$orig_h *= $this->img_dpi / $dpi;
						}
					}
				}
				$x_repeat = true;
				$y_repeat = true;
				if (isset($properties['BACKGROUND-REPEAT'])) {
					if ($properties['BACKGROUND-REPEAT'] == 'no-repeat' || $properties['BACKGROUND-REPEAT'] == 'repeat-x') {
						$y_repeat = false;
					}
					if ($properties['BACKGROUND-REPEAT'] == 'no-repeat' || $properties['BACKGROUND-REPEAT'] == 'repeat-y') {
						$x_repeat = false;
					}
				}
				$x_pos = 0;
				$y_pos = 0;
				if (isset($properties['BACKGROUND-POSITION'])) {
					$ppos = preg_split('/\s+/', $properties['BACKGROUND-POSITION']);
					$x_pos = $ppos[0];
					$y_pos = $ppos[1];
					if (!stristr($x_pos, '%')) {
						$x_pos = $this->ConvertSize($x_pos, $maxwidth, $this->FontSize);
					}
					if (!stristr($y_pos, '%')) {
						$y_pos = $this->ConvertSize($y_pos, $maxwidth, $this->FontSize);
					}
				}
				if (isset($properties['BACKGROUND-IMAGE-RESIZE'])) {
					$resize = $properties['BACKGROUND-IMAGE-RESIZE'];
				} else {
					$resize = 0;
				}
				if (isset($properties['BACKGROUND-IMAGE-OPACITY'])) {
					$opacity = $properties['BACKGROUND-IMAGE-OPACITY'];
				} else {
					$opacity = 1;
				}
				return array('image_id' => $image_id, 'orig_w' => $orig_w, 'orig_h' => $orig_h, 'x_pos' => $x_pos, 'y_pos' => $y_pos, 'x_repeat' => $x_repeat, 'y_repeat' => $y_repeat, 'resize' => $resize, 'opacity' => $opacity, 'itype' => $sizesarray['itype'], 'origin' => $origin, 'size' => $size);
			}
		}
		return false;
	}

	/* -- END BACKGROUNDS -- */

	function PrintBodyBackgrounds()
	{
		$s = '';
		$clx = 0;
		$cly = 0;
		$clw = $this->w;
		$clh = $this->h;
		// If using bleed and trim margins in paged media
		if ($this->pageDim[$this->page]['outer_width_LR'] || $this->pageDim[$this->page]['outer_width_TB']) {
			$clx = $this->pageDim[$this->page]['outer_width_LR'] - $this->pageDim[$this->page]['bleedMargin'];
			$cly = $this->pageDim[$this->page]['outer_width_TB'] - $this->pageDim[$this->page]['bleedMargin'];
			$clw = $this->w - 2 * $clx;
			$clh = $this->h - 2 * $cly;
		}

		if ($this->bodyBackgroundColor) {
			$s .= 'q ' . $this->SetFColor($this->bodyBackgroundColor, true) . "\n";
			if ($this->bodyBackgroundColor{0} == 5) { // RGBa
				$s .= $this->SetAlpha(ord($this->bodyBackgroundColor{4}) / 100, 'Normal', true, 'F') . "\n";
			} elseif ($this->bodyBackgroundColor{0} == 6) { // CMYKa
				$s .= $this->SetAlpha(ord($this->bodyBackgroundColor{5}) / 100, 'Normal', true, 'F') . "\n";
			}
			$s .= sprintf('%.3F %.3F %.3F %.3F re f Q', ($clx * _MPDFK), ($cly * _MPDFK), $clw * _MPDFK, $clh * _MPDFK) . "\n";
		}

		/* -- BACKGROUNDS -- */
		if ($this->bodyBackgroundGradient) {
			$g = $this->grad->parseBackgroundGradient($this->bodyBackgroundGradient);
			if ($g) {
				$s .= $this->grad->Gradient($clx, $cly, $clw, $clh, (isset($g['gradtype']) ? $g['gradtype'] : null), $g['stops'], $g['colorspace'], $g['coords'], $g['extend'], true);
			}
		}
		if ($this->bodyBackgroundImage) {
			if (isset($this->bodyBackgroundImage['gradient']) && $this->bodyBackgroundImage['gradient'] && preg_match('/(-moz-)*(repeating-)*(linear|radial)-gradient/', $this->bodyBackgroundImage['gradient'])) {
				$g = $this->grad->parseMozGradient($this->bodyBackgroundImage['gradient']);
				if ($g) {
					$s .= $this->grad->Gradient($clx, $cly, $clw, $clh, $g['type'], $g['stops'], $g['colorspace'], $g['coords'], $g['extend'], true);
				}
			} elseif ($this->bodyBackgroundImage['image_id']) { // Background pattern
				$n = count($this->patterns) + 1;
				// If using resize, uses TrimBox (not including the bleed)
				list($orig_w, $orig_h, $x_repeat, $y_repeat) = $this->_resizeBackgroundImage($this->bodyBackgroundImage['orig_w'], $this->bodyBackgroundImage['orig_h'], $clw, $clh, $this->bodyBackgroundImage['resize'], $this->bodyBackgroundImage['x_repeat'], $this->bodyBackgroundImage['y_repeat']);

				$this->patterns[$n] = array('x' => $clx, 'y' => $cly, 'w' => $clw, 'h' => $clh, 'pgh' => $this->h, 'image_id' => $this->bodyBackgroundImage['image_id'], 'orig_w' => $orig_w, 'orig_h' => $orig_h, 'x_pos' => $this->bodyBackgroundImage['x_pos'], 'y_pos' => $this->bodyBackgroundImage['y_pos'], 'x_repeat' => $x_repeat, 'y_repeat' => $y_repeat, 'itype' => $this->bodyBackgroundImage['itype']);
				if (($this->bodyBackgroundImage['opacity'] > 0 || $this->bodyBackgroundImage['opacity'] === '0') && $this->bodyBackgroundImage['opacity'] < 1) {
					$opac = $this->SetAlpha($this->bodyBackgroundImage['opacity'], 'Normal', true);
				} else {
					$opac = '';
				}
				$s .= sprintf('q /Pattern cs /P%d scn %s %.3F %.3F %.3F %.3F re f Q', $n, $opac, ($clx * _MPDFK), ($cly * _MPDFK), $clw * _MPDFK, $clh * _MPDFK) . "\n";
			}
		}
		/* -- END BACKGROUNDS -- */
		return $s;
	}

	function _setClippingPath($clx, $cly, $clw, $clh)
	{
		$s = ' q 0 w '; // Line width=0
		$s .= sprintf('%.3F %.3F m ', ($clx) * _MPDFK, ($this->h - ($cly)) * _MPDFK); // start point TL before the arc
		$s .= sprintf('%.3F %.3F l ', ($clx) * _MPDFK, ($this->h - ($cly + $clh)) * _MPDFK); // line to BL
		$s .= sprintf('%.3F %.3F l ', ($clx + $clw) * _MPDFK, ($this->h - ($cly + $clh)) * _MPDFK); // line to BR
		$s .= sprintf('%.3F %.3F l ', ($clx + $clw) * _MPDFK, ($this->h - ($cly)) * _MPDFK); // line to TR
		$s .= sprintf('%.3F %.3F l ', ($clx) * _MPDFK, ($this->h - ($cly)) * _MPDFK); // line to TL
		$s .= ' W n '; // Ends path no-op & Sets the clipping path
		return $s;
	}

	function PrintPageBackgrounds($adjustmenty = 0)
	{
		$s = '';

		ksort($this->pageBackgrounds);
		foreach ($this->pageBackgrounds AS $bl => $pbs) {
			foreach ($pbs AS $pb) {
				if ((!isset($pb['image_id']) && !isset($pb['gradient'])) || isset($pb['shadowonly'])) { // Background colour or boxshadow
					if ($pb['z-index'] > 0) {
						$this->current_layer = $pb['z-index'];
						$s .= "\n" . '/OCBZ-index /ZI' . $pb['z-index'] . ' BDC' . "\n";
					}

					if ($pb['visibility'] != 'visible') {
						if ($pb['visibility'] == 'printonly')
							$s .= '/OC /OC1 BDC' . "\n";
						elseif ($pb['visibility'] == 'screenonly')
							$s .= '/OC /OC2 BDC' . "\n";
						elseif ($pb['visibility'] == 'hidden')
							$s .= '/OC /OC3 BDC' . "\n";
					}
					// Box shadow
					if (isset($pb['shadow']) && $pb['shadow']) {
						$s .= $pb['shadow'] . "\n";
					}
					if (isset($pb['clippath']) && $pb['clippath']) {
						$s .= $pb['clippath'] . "\n";
					}
					$s .= 'q ' . $this->SetFColor($pb['col'], true) . "\n";
					if ($pb['col']{0} == 5) { // RGBa
						$s .= $this->SetAlpha(ord($pb['col']{4}) / 100, 'Normal', true, 'F') . "\n";
					} elseif ($pb['col']{0} == 6) { // CMYKa
						$s .= $this->SetAlpha(ord($pb['col']{5}) / 100, 'Normal', true, 'F') . "\n";
					}
					$s .= sprintf('%.3F %.3F %.3F %.3F re f Q', $pb['x'] * _MPDFK, ($this->h - $pb['y']) * _MPDFK, $pb['w'] * _MPDFK, -$pb['h'] * _MPDFK) . "\n";
					if (isset($pb['clippath']) && $pb['clippath']) {
						$s .= 'Q' . "\n";
					}
					if ($pb['visibility'] != 'visible')
						$s .= 'EMC' . "\n";

					if ($pb['z-index'] > 0) {
						$s .= "\n" . 'EMCBZ-index' . "\n";
						$this->current_layer = 0;
					}
				}
			}
			/* -- BACKGROUNDS -- */
			foreach ($pbs AS $pb) {
				if ((isset($pb['gradient']) && $pb['gradient']) || (isset($pb['image_id']) && $pb['image_id'])) {
					if ($pb['z-index'] > 0) {
						$this->current_layer = $pb['z-index'];
						$s .= "\n" . '/OCGZ-index /ZI' . $pb['z-index'] . ' BDC' . "\n";
					}
					if ($pb['visibility'] != 'visible') {
						if ($pb['visibility'] == 'printonly')
							$s .= '/OC /OC1 BDC' . "\n";
						elseif ($pb['visibility'] == 'screenonly')
							$s .= '/OC /OC2 BDC' . "\n";
						elseif ($pb['visibility'] == 'hidden')
							$s .= '/OC /OC3 BDC' . "\n";
					}
				}
				if (isset($pb['gradient']) && $pb['gradient']) {
					if (isset($pb['clippath']) && $pb['clippath']) {
						$s .= $pb['clippath'] . "\n";
					}
					$s .= $this->grad->Gradient($pb['x'], $pb['y'], $pb['w'], $pb['h'], $pb['gradtype'], $pb['stops'], $pb['colorspace'], $pb['coords'], $pb['extend'], true);
					if (isset($pb['clippath']) && $pb['clippath']) {
						$s .= 'Q' . "\n";
					}
				} elseif (isset($pb['image_id']) && $pb['image_id']) { // Background Image
					$pb['y'] -= $adjustmenty;
					$pb['h'] += $adjustmenty;
					$n = count($this->patterns) + 1;
					list($orig_w, $orig_h, $x_repeat, $y_repeat) = $this->_resizeBackgroundImage($pb['orig_w'], $pb['orig_h'], $pb['w'], $pb['h'], $pb['resize'], $pb['x_repeat'], $pb['y_repeat'], $pb['bpa'], $pb['size']);
					$this->patterns[$n] = array('x' => $pb['x'], 'y' => $pb['y'], 'w' => $pb['w'], 'h' => $pb['h'], 'pgh' => $this->h, 'image_id' => $pb['image_id'], 'orig_w' => $orig_w, 'orig_h' => $orig_h, 'x_pos' => $pb['x_pos'], 'y_pos' => $pb['y_pos'], 'x_repeat' => $x_repeat, 'y_repeat' => $y_repeat, 'itype' => $pb['itype'], 'bpa' => $pb['bpa']);
					$x = $pb['x'] * _MPDFK;
					$y = ($this->h - $pb['y']) * _MPDFK;
					$w = $pb['w'] * _MPDFK;
					$h = -$pb['h'] * _MPDFK;
					if (isset($pb['clippath']) && $pb['clippath']) {
						$s .= $pb['clippath'] . "\n";
					}
					if ($this->writingHTMLfooter || $this->writingHTMLheader) { // Write each (tiles) image rather than use as a pattern
						$iw = $pb['orig_w'] / _MPDFK;
						$ih = $pb['orig_h'] / _MPDFK;

						$w = $pb['w'];
						$h = $pb['h'];
						$x0 = $pb['x'];
						$y0 = $pb['y'];

						if (isset($pb['bpa']) && $pb['bpa']) {
							$w = $pb['bpa']['w'];
							$h = $pb['bpa']['h'];
							$x0 = $pb['bpa']['x'];
							$y0 = $pb['bpa']['y'];
						}

						if (isset($pb['size']['w']) && $pb['size']['w']) {
							$size = $pb['size'];

							if ($size['w'] == 'contain') {
								// Scale the image, while preserving its intrinsic aspect ratio (if any), to the largest size such that both its width and its height can fit inside the background positioning area.
								// Same as resize==3
								$ih = $ih * $pb['bpa']['w'] / $iw;
								$iw = $pb['bpa']['w'];
								if ($ih > $pb['bpa']['h']) {
									$iw = $iw * $pb['bpa']['h'] / $ih;
									$ih = $pb['bpa']['h'];
								}
							} elseif ($size['w'] == 'cover') {
								// Scale the image, while preserving its intrinsic aspect ratio (if any), to the smallest size such that both its width and its height can completely cover the background positioning area.
								$ih = $ih * $pb['bpa']['w'] / $iw;
								$iw = $pb['bpa']['w'];
								if ($ih < $pb['bpa']['h']) {
									$iw = $iw * $ih / $pb['bpa']['h'];
									$ih = $pb['bpa']['h'];
								}
							} else {
								if (stristr($size['w'], '%')) {
									$size['w'] += 0;
									$size['w'] /= 100;
									$size['w'] = ($pb['bpa']['w'] * $size['w']);
								}
								if (stristr($size['h'], '%')) {
									$size['h'] += 0;
									$size['h'] /= 100;
									$size['h'] = ($pb['bpa']['h'] * $size['h']);
								}
								if ($size['w'] == 'auto' && $size['h'] == 'auto') {
									$iw = $iw;
									$ih = $ih;
								} elseif ($size['w'] == 'auto' && $size['h'] != 'auto') {
									$iw = $iw * $size['h'] / $ih;
									$ih = $size['h'];
								} elseif ($size['w'] != 'auto' && $size['h'] == 'auto') {
									$ih = $ih * $size['w'] / $iw;
									$iw = $size['w'];
								} else {
									$iw = $size['w'];
									$ih = $size['h'];
								}
							}
						}

						// Number to repeat
						if ($pb['x_repeat']) {
							$nx = ceil($pb['w'] / $iw) + 1;
						} else {
							$nx = 1;
						}
						if ($pb['y_repeat']) {
							$ny = ceil($pb['h'] / $ih) + 1;
						} else {
							$ny = 1;
						}

						$x_pos = $pb['x_pos'];
						if (stristr($x_pos, '%')) {
							$x_pos += 0;
							$x_pos /= 100;
							$x_pos = ($pb['bpa']['w'] * $x_pos) - ($iw * $x_pos);
						}
						$y_pos = $pb['y_pos'];
						if (stristr($y_pos, '%')) {
							$y_pos += 0;
							$y_pos /= 100;
							$y_pos = ($pb['bpa']['h'] * $y_pos) - ($ih * $y_pos);
						}
						if ($nx > 1) {
							while ($x_pos > ($pb['x'] - $pb['bpa']['x'])) {
								$x_pos -= $iw;
							}
						}
						if ($ny > 1) {
							while ($y_pos > ($pb['y'] - $pb['bpa']['y'])) {
								$y_pos -= $ih;
							}
						}
						for ($xi = 0; $xi < $nx; $xi++) {
							for ($yi = 0; $yi < $ny; $yi++) {
								$x = $x0 + $x_pos + ($iw * $xi);
								$y = $y0 + $y_pos + ($ih * $yi);
								if ($pb['opacity'] > 0 && $pb['opacity'] < 1) {
									$opac = $this->SetAlpha($pb['opacity'], 'Normal', true);
								} else {
									$opac = '';
								}
								$s .= sprintf("q %s %.3F 0 0 %.3F %.3F %.3F cm /I%d Do Q", $opac, $iw * _MPDFK, $ih * _MPDFK, $x * _MPDFK, ($this->h - ($y + $ih)) * _MPDFK, $pb['image_id']) . "\n";
							}
						}
					} else {
						if (($pb['opacity'] > 0 || $pb['opacity'] === '0') && $pb['opacity'] < 1) {
							$opac = $this->SetAlpha($pb['opacity'], 'Normal', true);
						} else {
							$opac = '';
						}
						$s .= sprintf('q /Pattern cs /P%d scn %s %.3F %.3F %.3F %.3F re f Q', $n, $opac, $x, $y, $w, $h) . "\n";
					}
					if (isset($pb['clippath']) && $pb['clippath']) {
						$s .= 'Q' . "\n";
					}
				}
				if ((isset($pb['gradient']) && $pb['gradient']) || (isset($pb['image_id']) && $pb['image_id'])) {
					if ($pb['visibility'] != 'visible')
						$s .= 'EMC' . "\n";

					if ($pb['z-index'] > 0) {
						$s .= "\n" . 'EMCGZ-index' . "\n";
						$this->current_layer = 0;
					}
				}
			}
			/* -- END BACKGROUNDS -- */
		}
		return $s;
	}

	function PrintTableBackgrounds($adjustmenty = 0)
	{
		$s = '';
		/* -- BACKGROUNDS -- */
		ksort($this->tableBackgrounds);
		foreach ($this->tableBackgrounds AS $bl => $pbs) {
			foreach ($pbs AS $pb) {
				if ((!isset($pb['gradient']) || !$pb['gradient']) && (!isset($pb['image_id']) || !$pb['image_id'])) {
					$s .= 'q ' . $this->SetFColor($pb['col'], true) . "\n";
					if ($pb['col']{0} == 5) { // RGBa
						$s .= $this->SetAlpha(ord($pb['col']{4}) / 100, 'Normal', true, 'F') . "\n";
					} elseif ($pb['col']{0} == 6) { // CMYKa
						$s .= $this->SetAlpha(ord($pb['col']{5}) / 100, 'Normal', true, 'F') . "\n";
					}
					$s .= sprintf('%.3F %.3F %.3F %.3F re %s Q', $pb['x'] * _MPDFK, ($this->h - $pb['y']) * _MPDFK, $pb['w'] * _MPDFK, -$pb['h'] * _MPDFK, 'f') . "\n";
				}
				if (isset($pb['gradient']) && $pb['gradient']) {
					if (isset($pb['clippath']) && $pb['clippath']) {
						$s .= $pb['clippath'] . "\n";
					}
					$s .= $this->grad->Gradient($pb['x'], $pb['y'], $pb['w'], $pb['h'], $pb['gradtype'], $pb['stops'], $pb['colorspace'], $pb['coords'], $pb['extend'], true);
					if (isset($pb['clippath']) && $pb['clippath']) {
						$s .= 'Q' . "\n";
					}
				}
				if (isset($pb['image_id']) && $pb['image_id']) { // Background pattern
					$pb['y'] -= $adjustmenty;
					$pb['h'] += $adjustmenty;
					$n = count($this->patterns) + 1;
					list($orig_w, $orig_h, $x_repeat, $y_repeat) = $this->_resizeBackgroundImage($pb['orig_w'], $pb['orig_h'], $pb['w'], $pb['h'], $pb['resize'], $pb['x_repeat'], $pb['y_repeat']);
					$this->patterns[$n] = array('x' => $pb['x'], 'y' => $pb['y'], 'w' => $pb['w'], 'h' => $pb['h'], 'pgh' => $this->h, 'image_id' => $pb['image_id'], 'orig_w' => $orig_w, 'orig_h' => $orig_h, 'x_pos' => $pb['x_pos'], 'y_pos' => $pb['y_pos'], 'x_repeat' => $x_repeat, 'y_repeat' => $y_repeat, 'itype' => $pb['itype']);
					$x = $pb['x'] * _MPDFK;
					$y = ($this->h - $pb['y']) * _MPDFK;
					$w = $pb['w'] * _MPDFK;
					$h = -$pb['h'] * _MPDFK;

					// mPDF 5.7.3
					if (($this->writingHTMLfooter || $this->writingHTMLheader) && (!isset($pb['clippath']) || $pb['clippath'] == '')) {
						// Set clipping path
						$pb['clippath'] = sprintf(' q 0 w %.3F %.3F m %.3F %.3F l %.3F %.3F l %.3F %.3F l %.3F %.3F l W n ', $x, $y, $x, $y + $h, $x + $w, $y + $h, $x + $w, $y, $x, $y);
					}

					if (isset($pb['clippath']) && $pb['clippath']) {
						$s .= $pb['clippath'] . "\n";
					}

					// mPDF 5.7.3
					if ($this->writingHTMLfooter || $this->writingHTMLheader) { // Write each (tiles) image rather than use as a pattern
						$iw = $pb['orig_w'] / _MPDFK;
						$ih = $pb['orig_h'] / _MPDFK;

						$w = $pb['w'];
						$h = $pb['h'];
						$x0 = $pb['x'];
						$y0 = $pb['y'];

						if (isset($pb['bpa']) && $pb['bpa']) {
							$w = $pb['bpa']['w'];
							$h = $pb['bpa']['h'];
							$x0 = $pb['bpa']['x'];
							$y0 = $pb['bpa']['y'];
						}
						// At present 'bpa' (background page area) is not set for tablebackgrounds - only pagebackgrounds
						// For now, just set it as:
						else {
							$pb['bpa'] = array('x' => $x0, 'y' => $y0, 'w' => $w, 'h' => $h);
						}

						if (isset($pb['size']['w']) && $pb['size']['w']) {
							$size = $pb['size'];

							if ($size['w'] == 'contain') {
								// Scale the image, while preserving its intrinsic aspect ratio (if any), to the largest size such that both its width and its height can fit inside the background positioning area.
								// Same as resize==3
								$ih = $ih * $pb['bpa']['w'] / $iw;
								$iw = $pb['bpa']['w'];
								if ($ih > $pb['bpa']['h']) {
									$iw = $iw * $pb['bpa']['h'] / $ih;
									$ih = $pb['bpa']['h'];
								}
							} elseif ($size['w'] == 'cover') {
								// Scale the image, while preserving its intrinsic aspect ratio (if any), to the smallest size such that both its width and its height can completely cover the background positioning area.
								$ih = $ih * $pb['bpa']['w'] / $iw;
								$iw = $pb['bpa']['w'];
								if ($ih < $pb['bpa']['h']) {
									$iw = $iw * $ih / $pb['bpa']['h'];
									$ih = $pb['bpa']['h'];
								}
							} else {
								if (stristr($size['w'], '%')) {
									$size['w'] += 0;
									$size['w'] /= 100;
									$size['w'] = ($pb['bpa']['w'] * $size['w']);
								}
								if (stristr($size['h'], '%')) {
									$size['h'] += 0;
									$size['h'] /= 100;
									$size['h'] = ($pb['bpa']['h'] * $size['h']);
								}
								if ($size['w'] == 'auto' && $size['h'] == 'auto') {
									$iw = $iw;
									$ih = $ih;
								} elseif ($size['w'] == 'auto' && $size['h'] != 'auto') {
									$iw = $iw * $size['h'] / $ih;
									$ih = $size['h'];
								} elseif ($size['w'] != 'auto' && $size['h'] == 'auto') {
									$ih = $ih * $size['w'] / $iw;
									$iw = $size['w'];
								} else {
									$iw = $size['w'];
									$ih = $size['h'];
								}
							}
						}

						// Number to repeat
						if (isset($pb['x_repeat']) && $pb['x_repeat']) {
							$nx = ceil($pb['w'] / $iw) + 1;
						} else {
							$nx = 1;
						}
						if (isset($pb['y_repeat']) && $pb['y_repeat']) {
							$ny = ceil($pb['h'] / $ih) + 1;
						} else {
							$ny = 1;
						}

						$x_pos = $pb['x_pos'];
						if (stristr($x_pos, '%')) {
							$x_pos += 0;
							$x_pos /= 100;
							$x_pos = ($pb['bpa']['w'] * $x_pos) - ($iw * $x_pos);
						}
						$y_pos = $pb['y_pos'];
						if (stristr($y_pos, '%')) {
							$y_pos += 0;
							$y_pos /= 100;
							$y_pos = ($pb['bpa']['h'] * $y_pos) - ($ih * $y_pos);
						}
						if ($nx > 1) {
							while ($x_pos > ($pb['x'] - $pb['bpa']['x'])) {
								$x_pos -= $iw;
							}
						}
						if ($ny > 1) {
							while ($y_pos > ($pb['y'] - $pb['bpa']['y'])) {
								$y_pos -= $ih;
							}
						}
						for ($xi = 0; $xi < $nx; $xi++) {
							for ($yi = 0; $yi < $ny; $yi++) {
								$x = $x0 + $x_pos + ($iw * $xi);
								$y = $y0 + $y_pos + ($ih * $yi);
								if ($pb['opacity'] > 0 && $pb['opacity'] < 1) {
									$opac = $this->SetAlpha($pb['opacity'], 'Normal', true);
								} else {
									$opac = '';
								}
								$s .= sprintf("q %s %.3F 0 0 %.3F %.3F %.3F cm /I%d Do Q", $opac, $iw * _MPDFK, $ih * _MPDFK, $x * _MPDFK, ($this->h - ($y + $ih)) * _MPDFK, $pb['image_id']) . "\n";
							}
						}
					} else {
						if (($pb['opacity'] > 0 || $pb['opacity'] === '0') && $pb['opacity'] < 1) {
							$opac = $this->SetAlpha($pb['opacity'], 'Normal', true);
						} else {
							$opac = '';
						}
						$s .= sprintf('q /Pattern cs /P%d scn %s %.3F %.3F %.3F %.3F re f Q', $n, $opac, $x, $y, $w, $h) . "\n";
					}

					if (isset($pb['clippath']) && $pb['clippath']) {
						$s .= 'Q' . "\n";
					}
				}
			}
		}
		/* -- END BACKGROUNDS -- */
		return $s;
	}

	function BeginLayer($id)
	{
		if ($this->current_layer > 0)
			$this->EndLayer();
		if ($id < 1) {
			return false;
		}
		if (!isset($this->layers[$id])) {
			$this->layers[$id] = array('name' => 'Layer ' . ($id));
			if (($this->PDFA || $this->PDFX)) {
				$this->PDFAXwarnings[] = "Cannot use layers when using PDFA or PDFX";
				return '';
			} elseif (!$this->PDFA && !$this->PDFX) {
				$this->pdf_version = '1.5';
			}
		}
		$this->current_layer = $id;
		$this->_out('/OCZ-index /ZI' . $id . ' BDC');

		$this->pageoutput[$this->page] = array();
	}

	function EndLayer()
	{
		if ($this->current_layer > 0) {
			$this->_out('EMCZ-index');
			$this->current_layer = 0;
		}
	}

	function AddPageByArray($a)
	{
		if (!is_array($a)) {
			$a = array();
		}
		$orientation = (isset($a['orientation']) ? $a['orientation'] : '');
		$condition = (isset($a['condition']) ? $a['condition'] : (isset($a['type']) ? $a['type'] : ''));
		$resetpagenum = (isset($a['resetpagenum']) ? $a['resetpagenum'] : '');
		$pagenumstyle = (isset($a['pagenumstyle']) ? $a['pagenumstyle'] : '');
		$suppress = (isset($a['suppress']) ? $a['suppress'] : '');
		$mgl = (isset($a['mgl']) ? $a['mgl'] : (isset($a['margin-left']) ? $a['margin-left'] : ''));
		$mgr = (isset($a['mgr']) ? $a['mgr'] : (isset($a['margin-right']) ? $a['margin-right'] : ''));
		$mgt = (isset($a['mgt']) ? $a['mgt'] : (isset($a['margin-top']) ? $a['margin-top'] : ''));
		$mgb = (isset($a['mgb']) ? $a['mgb'] : (isset($a['margin-bottom']) ? $a['margin-bottom'] : ''));
		$mgh = (isset($a['mgh']) ? $a['mgh'] : (isset($a['margin-header']) ? $a['margin-header'] : ''));
		$mgf = (isset($a['mgf']) ? $a['mgf'] : (isset($a['margin-footer']) ? $a['margin-footer'] : ''));
		$ohname = (isset($a['ohname']) ? $a['ohname'] : (isset($a['odd-header-name']) ? $a['odd-header-name'] : ''));
		$ehname = (isset($a['ehname']) ? $a['ehname'] : (isset($a['even-header-name']) ? $a['even-header-name'] : ''));
		$ofname = (isset($a['ofname']) ? $a['ofname'] : (isset($a['odd-footer-name']) ? $a['odd-footer-name'] : ''));
		$efname = (isset($a['efname']) ? $a['efname'] : (isset($a['even-footer-name']) ? $a['even-footer-name'] : ''));
		$ohvalue = (isset($a['ohvalue']) ? $a['ohvalue'] : (isset($a['odd-header-value']) ? $a['odd-header-value'] : 0));
		$ehvalue = (isset($a['ehvalue']) ? $a['ehvalue'] : (isset($a['even-header-value']) ? $a['even-header-value'] : 0));
		$ofvalue = (isset($a['ofvalue']) ? $a['ofvalue'] : (isset($a['odd-footer-value']) ? $a['odd-footer-value'] : 0));
		$efvalue = (isset($a['efvalue']) ? $a['efvalue'] : (isset($a['even-footer-value']) ? $a['even-footer-value'] : 0));
		$pagesel = (isset($a['pagesel']) ? $a['pagesel'] : (isset($a['pageselector']) ? $a['pageselector'] : ''));
		$newformat = (isset($a['newformat']) ? $a['newformat'] : (isset($a['sheet-size']) ? $a['sheet-size'] : ''));

		$this->AddPage($orientation, $condition, $resetpagenum, $pagenumstyle, $suppress, $mgl, $mgr, $mgt, $mgb, $mgh, $mgf, $ohname, $ehname, $ofname, $efname, $ohvalue, $ehvalue, $ofvalue, $efvalue, $pagesel, $newformat);
	}

	// mPDF 6 pagebreaktype
	function _preForcedPagebreak($pagebreaktype)
	{
		if ($pagebreaktype == 'cloneall') {
			// Close any open block tags
			$arr = array();
			$ai = 0;
			for ($b = $this->blklvl; $b > 0; $b--) {
				$this->tag->CloseTag($this->blk[$b]['tag'], $arr, $ai);
			}
			if ($this->blklvl == 0 && !empty($this->textbuffer)) { //Output previously buffered content
				$this->printbuffer($this->textbuffer, 1);
				$this->textbuffer = array();
			}
		} elseif ($pagebreaktype == 'clonebycss') {
			// Close open block tags whilst box-decoration-break==clone
			$arr = array();
			$ai = 0;
			for ($b = $this->blklvl; $b > 0; $b--) {
				if (isset($this->blk[$b]['box_decoration_break']) && $this->blk[$b]['box_decoration_break'] == 'clone') {
					$this->tag->CloseTag($this->blk[$b]['tag'], $arr, $ai);
				} else {
					if ($b == $this->blklvl && !empty($this->textbuffer)) { //Output previously buffered content
						$this->printbuffer($this->textbuffer, 1);
						$this->textbuffer = array();
					}
					break;
				}
			}
		} elseif (!empty($this->textbuffer)) { //Output previously buffered content
			$this->printbuffer($this->textbuffer, 1);
			$this->textbuffer = array();
		}
	}

	// mPDF 6 pagebreaktype
	function _postForcedPagebreak($pagebreaktype, $startpage, $save_blk, $save_blklvl)
	{
		if ($pagebreaktype == 'cloneall') {
			$this->blk = array();
			$this->blk[0] = $save_blk[0];
			// Re-open block tags
			$this->blklvl = 0;
			$arr = array();
			$i = 0;
			for ($b = 1; $b <= $save_blklvl; $b++) {
				$this->tag->OpenTag($save_blk[$b]['tag'], $save_blk[$b]['attr'], $arr, $i);
			}
		} elseif ($pagebreaktype == 'clonebycss') {
			$this->blk = array();
			$this->blk[0] = $save_blk[0];
			// Don't re-open tags for lowest level elements - so need to do some adjustments
			for ($b = 1; $b <= $this->blklvl; $b++) {
				$this->blk[$b] = $save_blk[$b];
				$this->blk[$b]['startpage'] = 0;
				$this->blk[$b]['y0'] = $this->y; // ?? $this->tMargin
				if (($this->page - $startpage) % 2) {
					if (isset($this->blk[$b]['x0'])) {
						$this->blk[$b]['x0'] += $this->MarginCorrection;
					} else {
						$this->blk[$b]['x0'] = $this->MarginCorrection;
					}
				}
				//for Float DIV
				$this->blk[$b]['marginCorrected'][$this->page] = true;
			}

			// Re-open block tags for any that have box_decoration_break==clone
			$arr = array();
			$i = 0;
			for ($b = $this->blklvl + 1; $b <= $save_blklvl; $b++) {
				if ($b < $this->blklvl) {
					$this->lastblocklevelchange = -1;
				}
				$this->tag->OpenTag($save_blk[$b]['tag'], $save_blk[$b]['attr'], $arr, $i);
			}
			if ($this->blk[$this->blklvl]['box_decoration_break'] != 'clone') {
				$this->lastblocklevelchange = -1;
			}
		} else {
			$this->lastblocklevelchange = -1;
		}
	}

	function AddPage($orientation = '', $condition = '', $resetpagenum = '', $pagenumstyle = '', $suppress = '', $mgl = '', $mgr = '', $mgt = '', $mgb = '', $mgh = '', $mgf = '', $ohname = '', $ehname = '', $ofname = '', $efname = '', $ohvalue = 0, $ehvalue = 0, $ofvalue = 0, $efvalue = 0, $pagesel = '', $newformat = '')
	{

		/* -- CSS-FLOAT -- */
		// Float DIV
		// Cannot do with columns on, or if any change in page orientation/margins etc.
		// If next page already exists - i.e background /headers and footers already written
		if ($this->state > 0 && $this->page < count($this->pages)) {
			$bak_cml = $this->cMarginL;
			$bak_cmr = $this->cMarginR;
			$bak_dw = $this->divwidth;
			// Paint Div Border if necessary
			if ($this->blklvl > 0) {
				$save_tr = $this->table_rotate; // *TABLES*
				$this->table_rotate = 0; // *TABLES*
				if ($this->y == $this->blk[$this->blklvl]['y0']) {
					$this->blk[$this->blklvl]['startpage'] ++;
				}
				if (($this->y > $this->blk[$this->blklvl]['y0']) || $this->flowingBlockAttr['is_table']) {
					$toplvl = $this->blklvl;
				} else {
					$toplvl = $this->blklvl - 1;
				}
				$sy = $this->y;
				for ($bl = 1; $bl <= $toplvl; $bl++) {
					$this->PaintDivBB('pagebottom', 0, $bl);
				}
				$this->y = $sy;
				$this->table_rotate = $save_tr; // *TABLES*
			}
			$s = $this->PrintPageBackgrounds();

			// Writes after the marker so not overwritten later by page background etc.
			$this->pages[$this->page] = preg_replace('/(___BACKGROUND___PATTERNS' . $this->uniqstr . ')/', '\\1' . "\n" . $s . "\n", $this->pages[$this->page]);
			$this->pageBackgrounds = array();
			$family = $this->FontFamily;
			$style = $this->FontStyle;
			$size = $this->FontSizePt;
			$lw = $this->LineWidth;
			$dc = $this->DrawColor;
			$fc = $this->FillColor;
			$tc = $this->TextColor;
			$cf = $this->ColorFlag;

			$this->printfloatbuffer();

			//Move to next page
			$this->page++;
			$this->ResetMargins();
			$this->SetAutoPageBreak($this->autoPageBreak, $this->bMargin);
			$this->x = $this->lMargin;
			$this->y = $this->tMargin;
			$this->FontFamily = '';
			$this->_out('2 J');
			$this->LineWidth = $lw;
			$this->_out(sprintf('%.3F w', $lw * _MPDFK));
			if ($family)
				$this->SetFont($family, $style, $size, true, true);
			$this->DrawColor = $dc;
			if ($dc != $this->defDrawColor)
				$this->_out($dc);
			$this->FillColor = $fc;
			if ($fc != $this->defFillColor)
				$this->_out($fc);
			$this->TextColor = $tc;
			$this->ColorFlag = $cf;
			for ($bl = 1; $bl <= $this->blklvl; $bl++) {
				$this->blk[$bl]['y0'] = $this->y;
				// Don't correct more than once for background DIV containing a Float
				if (!isset($this->blk[$bl]['marginCorrected'][$this->page])) {
					$this->blk[$bl]['x0'] += $this->MarginCorrection;
				}
				$this->blk[$bl]['marginCorrected'][$this->page] = true;
			}
			$this->cMarginL = $bak_cml;
			$this->cMarginR = $bak_cmr;
			$this->divwidth = $bak_dw;
			return '';
		}
		/* -- END CSS-FLOAT -- */

		//Start a new page
		if ($this->state == 0)
			$this->Open();

		$bak_cml = $this->cMarginL;
		$bak_cmr = $this->cMarginR;
		$bak_dw = $this->divwidth;


		$bak_lh = $this->lineheight;

		$orientation = substr(strtoupper($orientation), 0, 1);
		$condition = strtoupper($condition);


		if ($condition == 'E') { // only adds new page if needed to create an Even page
			if (!$this->mirrorMargins || ($this->page) % 2 == 0) {
				return false;
			}
		} elseif ($condition == 'O') { // only adds new page if needed to create an Odd page
			if (!$this->mirrorMargins || ($this->page) % 2 == 1) {
				return false;
			}
		} elseif ($condition == 'NEXT-EVEN') { // always adds at least one new page to create an Even page
			if (!$this->mirrorMargins) {
				$condition = '';
			} else {
				if ($pagesel) {
					$pbch = $pagesel;
					$pagesel = '';
				} // *CSS-PAGE*
				else {
					$pbch = false;
				} // *CSS-PAGE*
				$this->AddPage($this->CurOrientation, 'O');
				$this->extrapagebreak = true; // mPDF 6 pagebreaktype
				if ($pbch) {
					$pagesel = $pbch;
				} // *CSS-PAGE*
				$condition = '';
			}
		} elseif ($condition == 'NEXT-ODD') { // always adds at least one new page to create an Odd page
			if (!$this->mirrorMargins) {
				$condition = '';
			} else {
				if ($pagesel) {
					$pbch = $pagesel;
					$pagesel = '';
				} // *CSS-PAGE*
				else {
					$pbch = false;
				} // *CSS-PAGE*
				$this->AddPage($this->CurOrientation, 'E');
				$this->extrapagebreak = true; // mPDF 6 pagebreaktype
				if ($pbch) {
					$pagesel = $pbch;
				} // *CSS-PAGE*
				$condition = '';
			}
		}


		if ($resetpagenum || $pagenumstyle || $suppress) {
			$this->PageNumSubstitutions[] = array('from' => ($this->page + 1), 'reset' => $resetpagenum, 'type' => $pagenumstyle, 'suppress' => $suppress);
		}


		$save_tr = $this->table_rotate; // *TABLES*
		$this->table_rotate = 0; // *TABLES*
		$save_kwt = $this->kwt;
		$this->kwt = 0;
		$save_layer = $this->current_layer;
		$save_vis = $this->visibility;

		if ($this->visibility != 'visible')
			$this->SetVisibility('visible');
		$this->EndLayer();

		// Paint Div Border if necessary
		//PAINTS BACKGROUND COLOUR OR BORDERS for DIV - DISABLED FOR COLUMNS (cf. AcceptPageBreak) AT PRESENT in ->PaintDivBB
		if (!$this->ColActive && $this->blklvl > 0) {
			if (isset($this->blk[$this->blklvl]['y0']) && $this->y == $this->blk[$this->blklvl]['y0'] && !$this->extrapagebreak) { // mPDF 6 pagebreaktype
				if (isset($this->blk[$this->blklvl]['startpage'])) {
					$this->blk[$this->blklvl]['startpage'] ++;
				} else {
					$this->blk[$this->blklvl]['startpage'] = 1;
				}
			}
			if ((isset($this->blk[$this->blklvl]['y0']) && $this->y > $this->blk[$this->blklvl]['y0']) || $this->flowingBlockAttr['is_table'] || $this->extrapagebreak) {
				$toplvl = $this->blklvl;
			} // mPDF 6 pagebreaktype
			else {
				$toplvl = $this->blklvl - 1;
			}
			$sy = $this->y;
			for ($bl = 1; $bl <= $toplvl; $bl++) {

				if (isset($this->blk[$bl]['z-index']) && $this->blk[$bl]['z-index'] > 0) {
					$this->BeginLayer($this->blk[$bl]['z-index']);
				}
				if (isset($this->blk[$bl]['visibility']) && $this->blk[$bl]['visibility'] && $this->blk[$bl]['visibility'] != 'visible') {
					$this->SetVisibility($this->blk[$bl]['visibility']);
				}
				$this->PaintDivBB('pagebottom', 0, $bl);
			}
			$this->y = $sy;
			// RESET block y0 and x0 - see below
		}
		$this->extrapagebreak = false; // mPDF 6 pagebreaktype

		if ($this->visibility != 'visible')
			$this->SetVisibility('visible');
		$this->EndLayer();

		// BODY Backgrounds
		if ($this->page > 0) {
			$s = '';
			$s .= $this->PrintBodyBackgrounds();

			$s .= $this->PrintPageBackgrounds();
			$this->pages[$this->page] = preg_replace('/(___BACKGROUND___PATTERNS' . $this->uniqstr . ')/', "\n" . $s . "\n" . '\\1', $this->pages[$this->page]);
			$this->pageBackgrounds = array();
		}

		$save_kt = $this->keep_block_together;
		$this->keep_block_together = 0;

		$save_cols = false;
		/* -- COLUMNS -- */
		if ($this->ColActive) {
			$save_cols = true;
			$save_nbcol = $this->NbCol; // other values of gap and vAlign will not change by setting Columns off
			$this->SetColumns(0);
		}
		/* -- END COLUMNS -- */


		$family = $this->FontFamily;
		$style = $this->FontStyle;
		$size = $this->FontSizePt;
		$this->ColumnAdjust = true; // enables column height adjustment for the page
		$lw = $this->LineWidth;
		$dc = $this->DrawColor;
		$fc = $this->FillColor;
		$tc = $this->TextColor;
		$cf = $this->ColorFlag;
		if ($this->page > 0) {
			//Page footer
			$this->InFooter = true;

			$this->Reset();
			$this->pageoutput[$this->page] = array();

			$this->Footer();
			//Close page
			$this->_endpage();
		}


		//Start new page
		$this->_beginpage($orientation, $mgl, $mgr, $mgt, $mgb, $mgh, $mgf, $ohname, $ehname, $ofname, $efname, $ohvalue, $ehvalue, $ofvalue, $efvalue, $pagesel, $newformat);
		if ($this->docTemplate) {
			$pagecount = $this->SetSourceFile($this->docTemplate);
			if (($this->page - $this->docTemplateStart) > $pagecount) {
				if ($this->docTemplateContinue) {
					$tplIdx = $this->ImportPage($pagecount);
					$this->UseTemplate($tplIdx);
				}
			} else {
				$tplIdx = $this->ImportPage(($this->page - $this->docTemplateStart));
				$this->UseTemplate($tplIdx);
			}
		}
		if ($this->pageTemplate) {
			$this->UseTemplate($this->pageTemplate);
		}

		// Tiling Patterns
		$this->_out('___PAGE___START' . $this->uniqstr);
		$this->_out('___BACKGROUND___PATTERNS' . $this->uniqstr);
		$this->_out('___HEADER___MARKER' . $this->uniqstr);
		$this->pageBackgrounds = array();

		//Set line cap style to square
		$this->SetLineCap(2);
		//Set line width
		$this->LineWidth = $lw;
		$this->_out(sprintf('%.3F w', $lw * _MPDFK));
		//Set font
		if ($family)
			$this->SetFont($family, $style, $size, true, true); // forces write

		//Set colors
		$this->DrawColor = $dc;
		if ($dc != $this->defDrawColor)
			$this->_out($dc);
		$this->FillColor = $fc;
		if ($fc != $this->defFillColor)
			$this->_out($fc);
		$this->TextColor = $tc;
		$this->ColorFlag = $cf;

		//Page header
		$this->Header();

		//Restore line width
		if ($this->LineWidth != $lw) {
			$this->LineWidth = $lw;
			$this->_out(sprintf('%.3F w', $lw * _MPDFK));
		}
		//Restore font
		if ($family)
			$this->SetFont($family, $style, $size, true, true); // forces write

		//Restore colors
		if ($this->DrawColor != $dc) {
			$this->DrawColor = $dc;
			$this->_out($dc);
		}
		if ($this->FillColor != $fc) {
			$this->FillColor = $fc;
			$this->_out($fc);
		}
		$this->TextColor = $tc;
		$this->ColorFlag = $cf;
		$this->InFooter = false;

		if ($save_layer > 0)
			$this->BeginLayer($save_layer);

		if ($save_vis != 'visible')
			$this->SetVisibility($save_vis);

		/* -- COLUMNS -- */
		if ($save_cols) {
			// Restore columns
			$this->SetColumns($save_nbcol, $this->colvAlign, $this->ColGap);
		}
		if ($this->ColActive) {
			$this->SetCol(0);
		}
		/* -- END COLUMNS -- */


		//RESET BLOCK BORDER TOP
		if (!$this->ColActive) {
			for ($bl = 1; $bl <= $this->blklvl; $bl++) {
				$this->blk[$bl]['y0'] = $this->y;
				if (isset($this->blk[$bl]['x0'])) {
					$this->blk[$bl]['x0'] += $this->MarginCorrection;
				} else {
					$this->blk[$bl]['x0'] = $this->MarginCorrection;
				}
				// Added mPDF 3.0 Float DIV
				$this->blk[$bl]['marginCorrected'][$this->page] = true;
			}
		}


		$this->table_rotate = $save_tr; // *TABLES*
		$this->kwt = $save_kwt;

		$this->keep_block_together = $save_kt;

		$this->cMarginL = $bak_cml;
		$this->cMarginR = $bak_cmr;
		$this->divwidth = $bak_dw;

		$this->lineheight = $bak_lh;
	}

	function PageNo()
	{
		//Get current page number
		return $this->page;
	}

	function AddSpotColorsFromFile($file)
	{
		$colors = @file($file);
		if (!$colors) {
			throw new MpdfException("Cannot load spot colors file - " . $file);
		}
		foreach ($colors AS $sc) {
			list($name, $c, $m, $y, $k) = preg_split("/\t/", $sc);
			$c = intval($c);
			$m = intval($m);
			$y = intval($y);
			$k = intval($k);
			$this->AddSpotColor($name, $c, $m, $y, $k);
		}
	}

	function AddSpotColor($name, $c, $m, $y, $k)
	{
		$name = strtoupper(trim($name));
		if (!isset($this->spotColors[$name])) {
			$i = count($this->spotColors) + 1;
			$this->spotColors[$name] = array('i' => $i, 'c' => $c, 'm' => $m, 'y' => $y, 'k' => $k);
			$this->spotColorIDs[$i] = $name;
		}
	}

	function SetColor($col, $type = '')
	{
		$out = '';
		if (!$col) {
			return '';
		} // mPDF 6
		if ($col{0} == 3 || $col{0} == 5) { // RGB / RGBa
			$out = sprintf('%.3F %.3F %.3F rg', ord($col{1}) / 255, ord($col{2}) / 255, ord($col{3}) / 255);
		} elseif ($col{0} == 1) { // GRAYSCALE
			$out = sprintf('%.3F g', ord($col{1}) / 255);
		} elseif ($col{0} == 2) { // SPOT COLOR
			$out = sprintf('/CS%d cs %.3F scn', ord($col{1}), ord($col{2}) / 100);
		} elseif ($col{0} == 4 || $col{0} == 6) { // CMYK / CMYKa
			$out = sprintf('%.3F %.3F %.3F %.3F k', ord($col{1}) / 100, ord($col{2}) / 100, ord($col{3}) / 100, ord($col{4}) / 100);
		}
		if ($type == 'Draw') {
			$out = strtoupper($out);
		} // e.g. rg => RG
		elseif ($type == 'CodeOnly') {
			$out = preg_replace('/\s(rg|g|k)/', '', $out);
		}
		return $out;
	}

	function SetDColor($col, $return = false)
	{
		$out = $this->SetColor($col, 'Draw');
		if ($return) {
			return $out;
		}
		if ($out == '') {
			return '';
		}
		$this->DrawColor = $out;
		if ($this->page > 0 && ((isset($this->pageoutput[$this->page]['DrawColor']) && $this->pageoutput[$this->page]['DrawColor'] != $this->DrawColor) || !isset($this->pageoutput[$this->page]['DrawColor']))) {
			$this->_out($this->DrawColor);
		}
		$this->pageoutput[$this->page]['DrawColor'] = $this->DrawColor;
	}

	function SetFColor($col, $return = false)
	{
		$out = $this->SetColor($col, 'Fill');
		if ($return) {
			return $out;
		}
		if ($out == '') {
			return '';
		}
		$this->FillColor = $out;
		$this->ColorFlag = ($out != $this->TextColor);
		if ($this->page > 0 && ((isset($this->pageoutput[$this->page]['FillColor']) && $this->pageoutput[$this->page]['FillColor'] != $this->FillColor) || !isset($this->pageoutput[$this->page]['FillColor']))) {
			$this->_out($this->FillColor);
		}
		$this->pageoutput[$this->page]['FillColor'] = $this->FillColor;
	}

	function SetTColor($col, $return = false)
	{
		$out = $this->SetColor($col, 'Text');
		if ($return) {
			return $out;
		}
		if ($out == '') {
			return '';
		}
		$this->TextColor = $out;
		$this->ColorFlag = ($this->FillColor != $out);
	}

	function SetDrawColor($r, $g = -1, $b = -1, $col4 = -1, $return = false)
	{
		//Set color for all stroking operations
		$col = array();
		if (($r == 0 and $g == 0 and $b == 0 && $col4 == -1) or $g == -1) {
			$col = $this->ConvertColor($r);
		} elseif ($col4 == -1) {
			$col = $this->ConvertColor('rgb(' . $r . ',' . $g . ',' . $b . ')');
		} else {
			$col = $this->ConvertColor('cmyk(' . $r . ',' . $g . ',' . $b . ',' . $col4 . ')');
		}
		$out = $this->SetDColor($col, $return);
		return $out;
	}

	function SetFillColor($r, $g = -1, $b = -1, $col4 = -1, $return = false)
	{
		//Set color for all filling operations
		$col = array();
		if (($r == 0 and $g == 0 and $b == 0 && $col4 == -1) or $g == -1) {
			$col = $this->ConvertColor($r);
		} elseif ($col4 == -1) {
			$col = $this->ConvertColor('rgb(' . $r . ',' . $g . ',' . $b . ')');
		} else {
			$col = $this->ConvertColor('cmyk(' . $r . ',' . $g . ',' . $b . ',' . $col4 . ')');
		}
		$out = $this->SetFColor($col, $return);
		return $out;
	}

	function SetTextColor($r, $g = -1, $b = -1, $col4 = -1, $return = false)
	{
		//Set color for text
		$col = array();
		if (($r == 0 and $g == 0 and $b == 0 && $col4 == -1) or $g == -1) {
			$col = $this->ConvertColor($r);
		} elseif ($col4 == -1) {
			$col = $this->ConvertColor('rgb(' . $r . ',' . $g . ',' . $b . ')');
		} else {
			$col = $this->ConvertColor('cmyk(' . $r . ',' . $g . ',' . $b . ',' . $col4 . ')');
		}
		$out = $this->SetTColor($col, $return);
		return $out;
	}

	function _getCharWidth(&$cw, $u, $isdef = true)
	{
		$w = 0;
		if ($u == 0) {
			$w = false;
		} elseif (isset($cw[$u * 2 + 1])) {
			$w = (ord($cw[$u * 2]) << 8) + ord($cw[$u * 2 + 1]);
		}
		if ($w == 65535) {
			return 0;
		} elseif ($w) {
			return $w;
		} elseif ($isdef) {
			return false;
		} else {
			return 0;
		}
	}

	function _charDefined(&$cw, $u)
	{
		$w = 0;
		if ($u == 0) {
			return false;
		}
		if (isset($cw[$u * 2 + 1])) {
			$w = (ord($cw[$u * 2]) << 8) + ord($cw[$u * 2 + 1]);
		}
		if ($w) {
			return true;
		} else {
			return false;
		}
	}

	function GetCharWidthCore($c)
	{
		//Get width of a single character in the current Core font
		$c = (string) $c;
		$w = 0;
		// Soft Hyphens chr(173)
		if ($c == chr(173) && $this->FontFamily != 'csymbol' && $this->FontFamily != 'czapfdingbats') {
			return 0;
		} elseif (($this->textvar & FC_SMALLCAPS) && isset($this->upperCase[ord($c)])) {  // mPDF 5.7.1
			$charw = $this->CurrentFont['cw'][chr($this->upperCase[ord($c)])];
			if ($charw !== false) {
				$charw = $charw * $this->smCapsScale * $this->smCapsStretch / 100;
				$w+=$charw;
			}
		} elseif (isset($this->CurrentFont['cw'][$c])) {
			$w += $this->CurrentFont['cw'][$c];
		} elseif (isset($this->CurrentFont['cw'][ord($c)])) {
			$w += $this->CurrentFont['cw'][ord($c)];
		}
		$w *= ($this->FontSize / 1000);
		if ($this->minwSpacing || $this->fixedlSpacing) {
			if ($c == ' ')
				$nb_spaces = 1;
			else
				$nb_spaces = 0;
			$w += $this->fixedlSpacing + ($nb_spaces * $this->minwSpacing);
		}
		return ($w);
	}

	function GetCharWidthNonCore($c, $addSubset = true)
	{
		//Get width of a single character in the current Non-Core font
		$c = (string) $c;
		$w = 0;
		$unicode = $this->UTF8StringToArray($c, $addSubset);
		$char = $unicode[0];
		/* -- CJK-FONTS -- */
		if ($this->CurrentFont['type'] == 'Type0') { // CJK Adobe fonts
			if ($char == 173) {
				return 0;
			} // Soft Hyphens
			elseif (isset($this->CurrentFont['cw'][$char])) {
				$w+=$this->CurrentFont['cw'][$char];
			} elseif (isset($this->CurrentFont['MissingWidth'])) {
				$w += $this->CurrentFont['MissingWidth'];
			} else {
				$w += 500;
			}
		} else {
			/* -- END CJK-FONTS -- */
			if ($char == 173) {
				return 0;
			} // Soft Hyphens
			elseif (($this->textvar & FC_SMALLCAPS) && isset($this->upperCase[$char])) { // mPDF 5.7.1
				$charw = $this->_getCharWidth($this->CurrentFont['cw'], $this->upperCase[$char]);
				if ($charw !== false) {
					$charw = $charw * $this->smCapsScale * $this->smCapsStretch / 100;
					$w+=$charw;
				} elseif (isset($this->CurrentFont['desc']['MissingWidth'])) {
					$w += $this->CurrentFont['desc']['MissingWidth'];
				} elseif (isset($this->CurrentFont['MissingWidth'])) {
					$w += $this->CurrentFont['MissingWidth'];
				} else {
					$w += 500;
				}
			} else {
				$charw = $this->_getCharWidth($this->CurrentFont['cw'], $char);
				if ($charw !== false) {
					$w+=$charw;
				} elseif (isset($this->CurrentFont['desc']['MissingWidth'])) {
					$w += $this->CurrentFont['desc']['MissingWidth'];
				} elseif (isset($this->CurrentFont['MissingWidth'])) {
					$w += $this->CurrentFont['MissingWidth'];
				} else {
					$w += 500;
				}
			}
		} // *CJK-FONTS*
		$w *= ($this->FontSize / 1000);
		if ($this->minwSpacing || $this->fixedlSpacing) {
			if ($c == ' ')
				$nb_spaces = 1;
			else
				$nb_spaces = 0;
			$w += $this->fixedlSpacing + ($nb_spaces * $this->minwSpacing);
		}
		return ($w);
	}

	function GetCharWidth($c, $addSubset = true)
	{
		if (!$this->usingCoreFont) {
			return $this->GetCharWidthNonCore($c, $addSubset);
		} else {
			return $this->GetCharWidthCore($c);
		}
	}

	function GetStringWidth($s, $addSubset = true, $OTLdata = false, $textvar = 0, $includeKashida = false)
	{ // mPDF 5.7.1
		//Get width of a string in the current font
		$s = (string) $s;
		$cw = &$this->CurrentFont['cw'];
		$w = 0;
		$kerning = 0;
		$lastchar = 0;
		$nb_carac = 0;
		$nb_spaces = 0;
		$kashida = 0;
		// mPDF ITERATION
		if ($this->iterationCounter)
			$s = preg_replace('/{iteration ([a-zA-Z0-9_]+)}/', '\\1', $s);
		if (!$this->usingCoreFont) {
			$discards = substr_count($s, "\xc2\xad"); // mPDF 6 soft hyphens [U+00AD]
			$unicode = $this->UTF8StringToArray($s, $addSubset);
			if ($this->minwSpacing || $this->fixedlSpacing) {
				$nb_spaces = mb_substr_count($s, ' ', $this->mb_enc);
				$nb_carac = count($unicode) - $discards; // mPDF 6
				// mPDF 5.7.1
				// Use GPOS OTL
				if (isset($this->CurrentFont['useOTL']) && $this->CurrentFont['useOTL']) {
					if (isset($OTLdata['group']) && $OTLdata['group']) {
						$nb_carac -= substr_count($OTLdata['group'], 'M');
					}
				}
			}
			/* -- CJK-FONTS -- */
			if ($this->CurrentFont['type'] == 'Type0') { // CJK Adobe fonts
				foreach ($unicode as $char) {
					if ($char == 0x00AD) {
						continue;
					} // mPDF 6 soft hyphens [U+00AD]
					if (isset($cw[$char])) {
						$w+=$cw[$char];
					} elseif (isset($this->CurrentFont['MissingWidth'])) {
						$w += $this->CurrentFont['MissingWidth'];
					} else {
						$w += 500;
					}
				}
			} else {
				/* -- END CJK-FONTS -- */
				foreach ($unicode as $i => $char) {
					if ($char == 0x00AD) {
						continue;
					} // mPDF 6 soft hyphens [U+00AD]
					if (($textvar & FC_SMALLCAPS) && isset($this->upperCase[$char])) {
						$charw = $this->_getCharWidth($cw, $this->upperCase[$char]);
						if ($charw !== false) {
							$charw = $charw * $this->smCapsScale * $this->smCapsStretch / 100;
							$w+=$charw;
						} elseif (isset($this->CurrentFont['desc']['MissingWidth'])) {
							$w += $this->CurrentFont['desc']['MissingWidth'];
						} elseif (isset($this->CurrentFont['MissingWidth'])) {
							$w += $this->CurrentFont['MissingWidth'];
						} else {
							$w += 500;
						}
					} else {
						$charw = $this->_getCharWidth($cw, $char);
						if ($charw !== false) {
							$w+=$charw;
						} elseif (isset($this->CurrentFont['desc']['MissingWidth'])) {
							$w += $this->CurrentFont['desc']['MissingWidth'];
						} elseif (isset($this->CurrentFont['MissingWidth'])) {
							$w += $this->CurrentFont['MissingWidth'];
						} else {
							$w += 500;
						}
						// mPDF 5.7.1
						// Use GPOS OTL
						// ...GetStringWidth...
						if (isset($this->CurrentFont['useOTL']) && ($this->CurrentFont['useOTL'] & 0xFF) && !empty($OTLdata)) {
							if (isset($OTLdata['GPOSinfo'][$i]['wDir']) && $OTLdata['GPOSinfo'][$i]['wDir'] == 'RTL') {
								if (isset($OTLdata['GPOSinfo'][$i]['XAdvanceR']) && $OTLdata['GPOSinfo'][$i]['XAdvanceR']) {
									$w += $OTLdata['GPOSinfo'][$i]['XAdvanceR'] * 1000 / $this->CurrentFont['unitsPerEm'];
								}
							} else {
								if (isset($OTLdata['GPOSinfo'][$i]['XAdvanceL']) && $OTLdata['GPOSinfo'][$i]['XAdvanceL']) {
									$w += $OTLdata['GPOSinfo'][$i]['XAdvanceL'] * 1000 / $this->CurrentFont['unitsPerEm'];
								}
							}
							// Kashida from GPOS
							// Kashida is set as an absolute length value (already set as a proportion based on useKashida %)
							if ($includeKashida && isset($OTLdata['GPOSinfo'][$i]['kashida_space']) && $OTLdata['GPOSinfo'][$i]['kashida_space']) {
								$kashida += $OTLdata['GPOSinfo'][$i]['kashida_space'];
							}
						}
						if (($textvar & FC_KERNING) && $lastchar) {
							if (isset($this->CurrentFont['kerninfo'][$lastchar][$char])) {
								$kerning += $this->CurrentFont['kerninfo'][$lastchar][$char];
							}
						}
						$lastchar = $char;
					}
				}
			} // *CJK-FONTS*
		} else {
			if ($this->FontFamily != 'csymbol' && $this->FontFamily != 'czapfdingbats') {
				$s = str_replace(chr(173), '', $s);
			}
			$nb_carac = $l = strlen($s);
			if ($this->minwSpacing || $this->fixedlSpacing) {
				$nb_spaces = substr_count($s, ' ');
			}
			for ($i = 0; $i < $l; $i++) {
				if (($textvar & FC_SMALLCAPS) && isset($this->upperCase[ord($s[$i])])) {  // mPDF 5.7.1
					$charw = $cw[chr($this->upperCase[ord($s[$i])])];
					if ($charw !== false) {
						$charw = $charw * $this->smCapsScale * $this->smCapsStretch / 100;
						$w+=$charw;
					}
				} elseif (isset($cw[$s[$i]])) {
					$w += $cw[$s[$i]];
				} elseif (isset($cw[ord($s[$i])])) {
					$w += $cw[ord($s[$i])];
				}
				if (($textvar & FC_KERNING) && $i > 0) { // mPDF 5.7.1
					if (isset($this->CurrentFont['kerninfo'][$s[($i - 1)]][$s[$i]])) {
						$kerning += $this->CurrentFont['kerninfo'][$s[($i - 1)]][$s[$i]];
					}
				}
			}
		}
		unset($cw);
		if ($textvar & FC_KERNING) {
			$w += $kerning;
		} // mPDF 5.7.1
		$w *= ($this->FontSize / 1000);
		$w += (($nb_carac + $nb_spaces) * $this->fixedlSpacing) + ($nb_spaces * $this->minwSpacing);
		$w += $kashida / _MPDFK;

		return ($w);
	}

	function SetLineWidth($width)
	{
		//Set line width
		$this->LineWidth = $width;
		$lwout = (sprintf('%.3F w', $width * _MPDFK));
		if ($this->page > 0 && ((isset($this->pageoutput[$this->page]['LineWidth']) && $this->pageoutput[$this->page]['LineWidth'] != $lwout) || !isset($this->pageoutput[$this->page]['LineWidth']))) {
			$this->_out($lwout);
		}
		$this->pageoutput[$this->page]['LineWidth'] = $lwout;
	}

	function Line($x1, $y1, $x2, $y2)
	{
		//Draw a line
		$this->_out(sprintf('%.3F %.3F m %.3F %.3F l S', $x1 * _MPDFK, ($this->h - $y1) * _MPDFK, $x2 * _MPDFK, ($this->h - $y2) * _MPDFK));
	}

	function Arrow($x1, $y1, $x2, $y2, $headsize = 3, $fill = 'B', $angle = 25)
	{
		//F == fill //S == stroke //B == stroke and fill
		// angle = splay of arrowhead - 1 - 89 degrees
		if ($fill == 'F')
			$fill = 'f';
		elseif ($fill == 'FD' or $fill == 'DF' or $fill == 'B')
			$fill = 'B';
		else
			$fill = 'S';
		$a = atan2(($y2 - $y1), ($x2 - $x1));
		$b = $a + deg2rad($angle);
		$c = $a - deg2rad($angle);
		$x3 = $x2 - ($headsize * cos($b));
		$y3 = $this->h - ($y2 - ($headsize * sin($b)));
		$x4 = $x2 - ($headsize * cos($c));
		$y4 = $this->h - ($y2 - ($headsize * sin($c)));

		$x5 = $x3 - ($x3 - $x4) / 2; // mid point of base of arrowhead - to join arrow line to
		$y5 = $y3 - ($y3 - $y4) / 2;

		$s = '';
		$s.=sprintf('%.3F %.3F m %.3F %.3F l S', $x1 * _MPDFK, ($this->h - $y1) * _MPDFK, $x5 * _MPDFK, $y5 * _MPDFK);
		$this->_out($s);

		$s = '';
		$s.=sprintf('%.3F %.3F m %.3F %.3F l %.3F %.3F l %.3F %.3F l %.3F %.3F l ', $x5 * _MPDFK, $y5 * _MPDFK, $x3 * _MPDFK, $y3 * _MPDFK, $x2 * _MPDFK, ($this->h - $y2) * _MPDFK, $x4 * _MPDFK, $y4 * _MPDFK, $x5 * _MPDFK, $y5 * _MPDFK);
		$s.=$fill;
		$this->_out($s);
	}

	function Rect($x, $y, $w, $h, $style = '')
	{
		//Draw a rectangle
		if ($style == 'F')
			$op = 'f';
		elseif ($style == 'FD' or $style == 'DF')
			$op = 'B';
		else
			$op = 'S';
		$this->_out(sprintf('%.3F %.3F %.3F %.3F re %s', $x * _MPDFK, ($this->h - $y) * _MPDFK, $w * _MPDFK, -$h * _MPDFK, $op));
	}

	function AddFont($family, $style = '')
	{
		if (empty($family)) {
			return;
		}
		$family = strtolower($family);
		$style = strtoupper($style);
		$style = str_replace('U', '', $style);
		if ($style == 'IB')
			$style = 'BI';
		$fontkey = $family . $style;
		// check if the font has been already added
		if (isset($this->fonts[$fontkey])) {
			return;
		}

		/* -- CJK-FONTS -- */
		if (in_array($family, $this->available_CJK_fonts)) {
			if (empty($this->Big5_widths)) {
				require(_MPDF_PATH . 'includes/CJKdata.php');
			}
			$this->AddCJKFont($family); // don't need to add style
			return;
		}
		/* -- END CJK-FONTS -- */

		if ($this->usingCoreFont) {
			throw new MpdfException("mPDF Error - problem with Font management");
		}

		$stylekey = $style;
		if (!$style) {
			$stylekey = 'R';
		}

		if (!isset($this->fontdata[$family][$stylekey]) || !$this->fontdata[$family][$stylekey]) {
			throw new MpdfException('mPDF Error - Font is not supported - ' . $family . ' ' . $style);
		}

		$name = '';
		$originalsize = 0;
		$sip = false;
		$smp = false;
		$useOTL = 0; // mPDF 5.7.1
		$fontmetrics = ''; // mPDF 6
		$haskerninfo = false;
		$haskernGPOS = false;
		$hassmallcapsGSUB = false;
		$BMPselected = false;
		$GSUBScriptLang = array();
		$GSUBFeatures = array();
		$GSUBLookups = array();
		$GPOSScriptLang = array();
		$GPOSFeatures = array();
		$GPOSLookups = array();
		if (file_exists(_MPDF_TTFONTDATAPATH . $fontkey . '.mtx.php')) {
			include(_MPDF_TTFONTDATAPATH . $fontkey . '.mtx.php');
		}

		$ttffile = '';
		if (defined('_MPDF_SYSTEM_TTFONTS')) {
			$ttffile = _MPDF_SYSTEM_TTFONTS . $this->fontdata[$family][$stylekey];
			if (!file_exists($ttffile)) {
				$ttffile = '';
			}
		}
		if (!$ttffile) {
			$ttffile = _MPDF_TTFONTPATH . $this->fontdata[$family][$stylekey];
			if (!file_exists($ttffile)) {
				throw new MpdfException("mPDF Error - cannot find TTF TrueType font file - " . $ttffile);
			}
		}
		$ttfstat = stat($ttffile);

		if (isset($this->fontdata[$family]['TTCfontID'][$stylekey])) {
			$TTCfontID = $this->fontdata[$family]['TTCfontID'][$stylekey];
		} else {
			$TTCfontID = 0;
		}

		$BMPonly = false;
		if (in_array($family, $this->BMPonly)) {
			$BMPonly = true;
		}
		$regenerate = false;
		if ($BMPonly && !$BMPselected) {
			$regenerate = true;
		} elseif (!$BMPonly && $BMPselected) {
			$regenerate = true;
		}
		// mPDF 5.7.1
		if (isset($this->fontdata[$family]['useOTL']) && $this->fontdata[$family]['useOTL'] && $useOTL != $this->fontdata[$family]['useOTL']) {
			$regenerate = true;
			$useOTL = $this->fontdata[$family]['useOTL'];
		} elseif ((!isset($this->fontdata[$family]['useOTL']) || !$this->fontdata[$family]['useOTL']) && $useOTL) {
			$regenerate = true;
			$useOTL = 0;
		}
		if (_FONT_DESCRIPTOR != $fontmetrics) {
			$regenerate = true;
		} // mPDF 6
		if (!isset($name) || $originalsize != $ttfstat['size'] || $regenerate) {
			if (!class_exists('TTFontFile', false)) {
				include(_MPDF_PATH . 'classes/ttfontsuni.php');
			}
			$ttf = new TTFontFile();
			$ttf->getMetrics($ttffile, $fontkey, $TTCfontID, $this->debugfonts, $BMPonly, $useOTL); // mPDF 5.7.1
			$cw = $ttf->charWidths;
			$kerninfo = $ttf->kerninfo;
			if ($kerninfo)
				$haskerninfo = true;
			$haskernGPOS = $ttf->haskernGPOS;
			$hassmallcapsGSUB = $ttf->hassmallcapsGSUB;
			$name = preg_replace('/[ ()]/', '', $ttf->fullName);
			$sip = $ttf->sipset;
			$smp = $ttf->smpset;
			// mPDF 6
			$GSUBScriptLang = $ttf->GSUBScriptLang;
			$GSUBFeatures = $ttf->GSUBFeatures;
			$GSUBLookups = $ttf->GSUBLookups;
			$rtlPUAstr = $ttf->rtlPUAstr;
			$GPOSScriptLang = $ttf->GPOSScriptLang;
			$GPOSFeatures = $ttf->GPOSFeatures;
			$GPOSLookups = $ttf->GPOSLookups;
			$glyphIDtoUni = $ttf->glyphIDtoUni;


			$desc = array(
				'CapHeight' => round($ttf->capHeight),
				'XHeight' => round($ttf->xHeight),
				'FontBBox' => '[' . round($ttf->bbox[0]) . " " . round($ttf->bbox[1]) . " " . round($ttf->bbox[2]) . " " . round($ttf->bbox[3]) . ']', /* FontBBox from head table */

				/* 		'MaxWidth' => round($ttf->advanceWidthMax),	// AdvanceWidthMax from hhea table	NB ArialUnicode MS = 31990 ! */
				'Flags' => $ttf->flags,
				'Ascent' => round($ttf->ascent),
				'Descent' => round($ttf->descent),
				'Leading' => round($ttf->lineGap),
				'ItalicAngle' => $ttf->italicAngle,
				'StemV' => round($ttf->stemV),
				'MissingWidth' => round($ttf->defaultWidth)
			);
			$panose = '';
			if (count($ttf->panose)) {
				$panoseArray = array_merge(array($ttf->sFamilyClass, $ttf->sFamilySubClass), $ttf->panose);
				foreach ($panoseArray as $value)
					$panose .= ' ' . dechex($value);
			}
			$unitsPerEm = round($ttf->unitsPerEm);
			$up = round($ttf->underlinePosition);
			$ut = round($ttf->underlineThickness);
			$strp = round($ttf->strikeoutPosition); // mPDF 6
			$strs = round($ttf->strikeoutSize); // mPDF 6
			$originalsize = $ttfstat['size'] + 0;
			$type = 'TTF';
			//Generate metrics .php file
			$s = '<?php' . "\n";
			$s.='$name=\'' . $name . "';\n";
			$s.='$type=\'' . $type . "';\n";
			$s.='$desc=' . var_export($desc, true) . ";\n";
			$s.='$unitsPerEm=' . $unitsPerEm . ";\n";
			$s.='$up=' . $up . ";\n";
			$s.='$ut=' . $ut . ";\n";
			$s.='$strp=' . $strp . ";\n"; // mPDF 6
			$s.='$strs=' . $strs . ";\n"; // mPDF 6
			$s.='$ttffile=\'' . $ttffile . "';\n";
			$s.='$TTCfontID=\'' . $TTCfontID . "';\n";
			$s.='$originalsize=' . $originalsize . ";\n";
			if ($sip)
				$s.='$sip=true;' . "\n";
			else
				$s.='$sip=false;' . "\n";
			if ($smp)
				$s.='$smp=true;' . "\n";
			else
				$s.='$smp=false;' . "\n";
			if ($BMPonly)
				$s.='$BMPselected=true;' . "\n";
			else
				$s.='$BMPselected=false;' . "\n";
			$s.='$fontkey=\'' . $fontkey . "';\n";
			$s.='$panose=\'' . $panose . "';\n";
			if ($haskerninfo)
				$s.='$haskerninfo=true;' . "\n";
			else
				$s.='$haskerninfo=false;' . "\n";
			if ($haskernGPOS)
				$s.='$haskernGPOS=true;' . "\n";
			else
				$s.='$haskernGPOS=false;' . "\n";
			if ($hassmallcapsGSUB)
				$s.='$hassmallcapsGSUB=true;' . "\n";
			else
				$s.='$hassmallcapsGSUB=false;' . "\n";
			$s.='$fontmetrics=\'' . _FONT_DESCRIPTOR . "';\n"; // mPDF 6

			$s.='// TypoAscender/TypoDescender/TypoLineGap = ' . round($ttf->typoAscender) . ', ' . round($ttf->typoDescender) . ', ' . round($ttf->typoLineGap) . "\n";
			$s.='// usWinAscent/usWinDescent = ' . round($ttf->usWinAscent) . ', ' . round(-$ttf->usWinDescent) . "\n";
			$s.='// hhea Ascent/Descent/LineGap = ' . round($ttf->hheaascent) . ', ' . round($ttf->hheadescent) . ', ' . round($ttf->hhealineGap) . "\n";

			//  mPDF 5.7.1
			if (isset($this->fontdata[$family]['useOTL'])) {
				$s.='$useOTL=' . $this->fontdata[$family]['useOTL'] . ';' . "\n";
			} else
				$s.='$useOTL=0x0000;' . "\n";
			if ($rtlPUAstr) {
				$s.='$rtlPUAstr=\'' . $rtlPUAstr . "';\n";
			} else
				$s.='$rtlPUAstr=\'\';' . "\n";
			if (count($GSUBScriptLang)) {
				$s.='$GSUBScriptLang=' . var_export($GSUBScriptLang, true) . ";\n";
			}
			if (count($GSUBFeatures)) {
				$s.='$GSUBFeatures=' . var_export($GSUBFeatures, true) . ";\n";
			}
			if (count($GSUBLookups)) {
				$s.='$GSUBLookups=' . var_export($GSUBLookups, true) . ";\n";
			}
			if (count($GPOSScriptLang)) {
				$s.='$GPOSScriptLang=' . var_export($GPOSScriptLang, true) . ";\n";
			}
			if (count($GPOSFeatures)) {
				$s.='$GPOSFeatures=' . var_export($GPOSFeatures, true) . ";\n";
			}
			if (count($GPOSLookups)) {
				$s.='$GPOSLookups=' . var_export($GPOSLookups, true) . ";\n";
			}
			if ($kerninfo) {
				$s.='$kerninfo=' . var_export($kerninfo, true) . ";\n";
			}
			$s.="?>";
			if (is_writable(dirname(_MPDF_TTFONTDATAPATH . 'x'))) {
				$fh = fopen(_MPDF_TTFONTDATAPATH . $fontkey . '.mtx.php', "w");
				fwrite($fh, $s, strlen($s));
				fclose($fh);
				$fh = fopen(_MPDF_TTFONTDATAPATH . $fontkey . '.cw.dat', "wb");
				fwrite($fh, $cw, strlen($cw));
				fclose($fh);
				// mPDF 5.7.1
				$fh = fopen(_MPDF_TTFONTDATAPATH . $fontkey . '.gid.dat', "wb");
				fwrite($fh, $glyphIDtoUni, strlen($glyphIDtoUni));
				fclose($fh);
				if (file_exists(_MPDF_TTFONTDATAPATH . $fontkey . '.cgm'))
					unlink(_MPDF_TTFONTDATAPATH . $fontkey . '.cgm');
				if (file_exists(_MPDF_TTFONTDATAPATH . $fontkey . '.z'))
					unlink(_MPDF_TTFONTDATAPATH . $fontkey . '.z');
				if (file_exists(_MPDF_TTFONTDATAPATH . $fontkey . '.cw127.php'))
					unlink(_MPDF_TTFONTDATAPATH . $fontkey . '.cw127.php');
				if (file_exists(_MPDF_TTFONTDATAPATH . $fontkey . '.cw'))
					unlink(_MPDF_TTFONTDATAPATH . $fontkey . '.cw');
			}
			elseif ($this->debugfonts) {
				throw new MpdfException('Cannot write to the font caching directory - ' . _MPDF_TTFONTDATAPATH);
			}
			unset($ttf);
		} else {
			$cw = '';
			$glyphIDtoUni = '';
			if (file_exists(_MPDF_TTFONTDATAPATH . $fontkey . '.cw.dat'))
				$cw = file_get_contents(_MPDF_TTFONTDATAPATH . $fontkey . '.cw.dat');
			if (file_exists(_MPDF_TTFONTDATAPATH . $fontkey . '.gid.dat'))
				$glyphIDtoUni = file_get_contents(_MPDF_TTFONTDATAPATH . $fontkey . '.gid.dat');
		}

		/* -- OTL -- */
		// mPDF 5.7.1
		// Use OTL OpenType Table Layout - GSUB
		if (isset($this->fontdata[$family]['useOTL']) && ($this->fontdata[$family]['useOTL'])) {
			if (!class_exists('otl', false)) {
				include(_MPDF_PATH . 'classes/otl.php');
			}
			if (empty($this->otl)) {
				$this->otl = new otl($this);
			}
		}
		/* -- END OTL -- */

		if (isset($this->fontdata[$family]['sip-ext']) && $this->fontdata[$family]['sip-ext']) {
			$sipext = $this->fontdata[$family]['sip-ext'];
		} else {
			$sipext = '';
		}

		// Override with values from config_font.php
		if (isset($this->fontdata[$family]['Ascent']) && $this->fontdata[$family]['Ascent']) {
			$desc['Ascent'] = $this->fontdata[$family]['Ascent'];
		}
		if (isset($this->fontdata[$family]['Descent']) && $this->fontdata[$family]['Descent']) {
			$desc['Descent'] = $this->fontdata[$family]['Descent'];
		}
		if (isset($this->fontdata[$family]['Leading']) && $this->fontdata[$family]['Leading']) {
			$desc['Leading'] = $this->fontdata[$family]['Leading'];
		}



		$i = count($this->fonts) + $this->extraFontSubsets + 1;
		if ($sip || $smp) {
			$this->fonts[$fontkey] = array('i' => $i, 'type' => $type, 'name' => $name, 'desc' => $desc, 'panose' => $panose, 'unitsPerEm' => $unitsPerEm, 'up' => $up, 'ut' => $ut, 'strs' => $strs, 'strp' => $strp, 'cw' => $cw, 'ttffile' => $ttffile, 'fontkey' => $fontkey, 'subsets' => array(0 => range(0, 127)), 'subsetfontids' => array($i), 'used' => false, 'sip' => $sip, 'sipext' => $sipext, 'smp' => $smp, 'TTCfontID' => $TTCfontID, 'useOTL' => (isset($this->fontdata[$family]['useOTL']) ? $this->fontdata[$family]['useOTL'] : false), 'useKashida' => (isset($this->fontdata[$family]['useKashida']) ? $this->fontdata[$family]['useKashida'] : false), 'GSUBScriptLang' => $GSUBScriptLang, 'GSUBFeatures' => $GSUBFeatures, 'GSUBLookups' => $GSUBLookups, 'GPOSScriptLang' => $GPOSScriptLang, 'GPOSFeatures' => $GPOSFeatures, 'GPOSLookups' => $GPOSLookups, 'rtlPUAstr' => $rtlPUAstr, 'glyphIDtoUni' => $glyphIDtoUni, 'haskerninfo' => $haskerninfo, 'haskernGPOS' => $haskernGPOS, 'hassmallcapsGSUB' => $hassmallcapsGSUB); // mPDF 5.7.1	// mPDF 6
		} else {
			$ss = array();
			for ($s = 32; $s < 128; $s++) {
				$ss[$s] = $s;
			}
			$this->fonts[$fontkey] = array('i' => $i, 'type' => $type, 'name' => $name, 'desc' => $desc, 'panose' => $panose, 'unitsPerEm' => $unitsPerEm, 'up' => $up, 'ut' => $ut, 'strs' => $strs, 'strp' => $strp, 'cw' => $cw, 'ttffile' => $ttffile, 'fontkey' => $fontkey, 'subset' => $ss, 'used' => false, 'sip' => $sip, 'sipext' => $sipext, 'smp' => $smp, 'TTCfontID' => $TTCfontID, 'useOTL' => (isset($this->fontdata[$family]['useOTL']) ? $this->fontdata[$family]['useOTL'] : false), 'useKashida' => (isset($this->fontdata[$family]['useKashida']) ? $this->fontdata[$family]['useKashida'] : false), 'GSUBScriptLang' => $GSUBScriptLang, 'GSUBFeatures' => $GSUBFeatures, 'GSUBLookups' => $GSUBLookups, 'GPOSScriptLang' => $GPOSScriptLang, 'GPOSFeatures' => $GPOSFeatures, 'GPOSLookups' => $GPOSLookups, 'rtlPUAstr' => $rtlPUAstr, 'glyphIDtoUni' => $glyphIDtoUni, 'haskerninfo' => $haskerninfo, 'haskernGPOS' => $haskernGPOS, 'hassmallcapsGSUB' => $hassmallcapsGSUB); // mPDF 5.7.1	// mPDF 6
		}
		if ($haskerninfo) {
			$this->fonts[$fontkey]['kerninfo'] = $kerninfo;
		}
		$this->FontFiles[$fontkey] = array('length1' => $originalsize, 'type' => "TTF", 'ttffile' => $ttffile, 'sip' => $sip, 'smp' => $smp);
		unset($cw);
	}

	function SetFont($family, $style = '', $size = 0, $write = true, $forcewrite = false)
	{
		$family = strtolower($family);
		if (!$this->onlyCoreFonts) {
			if ($family == 'sans' || $family == 'sans-serif') {
				$family = $this->sans_fonts[0];
			}
			if ($family == 'serif') {
				$family = $this->serif_fonts[0];
			}
			if ($family == 'mono' || $family == 'monospace') {
				$family = $this->mono_fonts[0];
			}
		}
		if (isset($this->fonttrans[$family]) && $this->fonttrans[$family]) {
			$family = $this->fonttrans[$family];
		}
		if ($family == '') {
			if ($this->FontFamily) {
				$family = $this->FontFamily;
			} elseif ($this->default_font) {
				$family = $this->default_font;
			} else {
				throw new MpdfException("No font or default font set!");
			}
		}
		$this->ReqFontStyle = $style; // required or requested style - used later for artificial bold/italic

		if (($family == 'csymbol') || ($family == 'czapfdingbats') || ($family == 'ctimes') || ($family == 'ccourier') || ($family == 'chelvetica')) {
			if ($this->PDFA || $this->PDFX) {
				if ($family == 'csymbol' || $family == 'czapfdingbats') {
					throw new MpdfException("Symbol and Zapfdingbats cannot be embedded in mPDF (required for PDFA1-b or PDFX/1-a).");
				}
				if ($family == 'ctimes' || $family == 'ccourier' || $family == 'chelvetica') {
					if (($this->PDFA && !$this->PDFAauto) || ($this->PDFX && !$this->PDFXauto)) {
						$this->PDFAXwarnings[] = "Core Adobe font " . ucfirst($family) . " cannot be embedded in mPDF, which is required for PDFA1-b or PDFX/1-a. (Embedded font will be substituted.)";
					}
					if ($family == 'chelvetica') {
						$family = 'sans';
					}
					if ($family == 'ctimes') {
						$family = 'serif';
					}
					if ($family == 'ccourier') {
						$family = 'mono';
					}
				}
				$this->usingCoreFont = false;
			} else {
				$this->usingCoreFont = true;
			}
			if ($family == 'csymbol' || $family == 'czapfdingbats') {
				$style = '';
			}
		} else {
			$this->usingCoreFont = false;
		}

		// mPDF 5.7.1
		if ($style) {
			$style = strtoupper($style);
			if ($style == 'IB')
				$style = 'BI';
		}
		if ($size == 0)
			$size = $this->FontSizePt;

		$fontkey = $family . $style;

		$stylekey = $style;
		if (!$stylekey) {
			$stylekey = "R";
		}

		if (!$this->onlyCoreFonts && !$this->usingCoreFont) {
			if (!isset($this->fonts[$fontkey]) || count($this->default_available_fonts) != count($this->available_unifonts)) { // not already added
				/* -- CJK-FONTS -- */
				// CJK fonts
				if (in_array($fontkey, $this->available_CJK_fonts)) {
					if (!isset($this->fonts[$fontkey])) { // already added
						if (empty($this->Big5_widths)) {
							require(_MPDF_PATH . 'includes/CJKdata.php');
						}
						$this->AddCJKFont($family); // don't need to add style
					}
				}
				// Test to see if requested font/style is available - or substitute
				else
				/* -- END CJK-FONTS -- */
				if (!in_array($fontkey, $this->available_unifonts)) {
					// If font[nostyle] exists - set it
					if (in_array($family, $this->available_unifonts)) {
						$style = '';
					}

					// elseif only one font available - set it (assumes if only one font available it will not have a style)
					elseif (count($this->available_unifonts) == 1) {
						$family = $this->available_unifonts[0];
						$style = '';
					} else {
						$found = 0;
						// else substitute font of similar type
						if (in_array($family, $this->sans_fonts)) {
							$i = array_intersect($this->sans_fonts, $this->available_unifonts);
							if (count($i)) {
								$i = array_values($i);
								// with requested style if possible
								if (!in_array(($i[0] . $style), $this->available_unifonts)) {
									$style = '';
								}
								$family = $i[0];
								$found = 1;
							}
						} elseif (in_array($family, $this->serif_fonts)) {
							$i = array_intersect($this->serif_fonts, $this->available_unifonts);
							if (count($i)) {
								$i = array_values($i);
								// with requested style if possible
								if (!in_array(($i[0] . $style), $this->available_unifonts)) {
									$style = '';
								}
								$family = $i[0];
								$found = 1;
							}
						} elseif (in_array($family, $this->mono_fonts)) {
							$i = array_intersect($this->mono_fonts, $this->available_unifonts);
							if (count($i)) {
								$i = array_values($i);
								// with requested style if possible
								if (!in_array(($i[0] . $style), $this->available_unifonts)) {
									$style = '';
								}
								$family = $i[0];
								$found = 1;
							}
						}

						if (!$found) {
							// set first available font
							$fs = $this->available_unifonts[0];
							preg_match('/^([a-z_0-9\-]+)([BI]{0,2})$/', $fs, $fas); // Allow "-"
							// with requested style if possible
							$ws = $fas[1] . $style;
							if (in_array($ws, $this->available_unifonts)) {
								$family = $fas[1]; // leave $style as is
							} elseif (in_array($fas[1], $this->available_unifonts)) {
								// or without style
								$family = $fas[1];
								$style = '';
							} else {
								// or with the style specified
								$family = $fas[1];
								$style = $fas[2];
							}
						}
					}
					$fontkey = $family . $style;
				}
			}
			// try to add font (if not already added)
			$this->AddFont($family, $style);

			//Test if font is already selected
			if ($this->FontFamily == $family && $this->FontFamily == $this->currentfontfamily && $this->FontStyle == $style && $this->FontStyle == $this->currentfontstyle && $this->FontSizePt == $size && $this->FontSizePt == $this->currentfontsize && !$forcewrite) {
				return $family;
			}

			$fontkey = $family . $style;

			//Select it
			$this->FontFamily = $family;
			$this->FontStyle = $style;
			$this->FontSizePt = $size;
			$this->FontSize = $size / _MPDFK;
			$this->CurrentFont = &$this->fonts[$fontkey];
			if ($write) {
				$fontout = (sprintf('BT /F%d %.3F Tf ET', $this->CurrentFont['i'], $this->FontSizePt));
				if ($this->page > 0 && ((isset($this->pageoutput[$this->page]['Font']) && $this->pageoutput[$this->page]['Font'] != $fontout) || !isset($this->pageoutput[$this->page]['Font']))) {
					$this->_out($fontout);
				}
				$this->pageoutput[$this->page]['Font'] = $fontout;
			}



			// Added - currentfont (lowercase) used in HTML2PDF
			$this->currentfontfamily = $family;
			$this->currentfontsize = $size;
			$this->currentfontstyle = $style;
			$this->setMBencoding('UTF-8');
		} else {  // if using core fonts
			if ($this->PDFA || $this->PDFX) {
				throw new MpdfException('Core Adobe fonts cannot be embedded in mPDF (required for PDFA1-b or PDFX/1-a) - cannot use option to use core fonts.');
			}
			$this->setMBencoding('windows-1252');

			//Test if font is already selected
			if (($this->FontFamily == $family) AND ( $this->FontStyle == $style) AND ( $this->FontSizePt == $size) && !$forcewrite) {
				return $family;
			}

			if (!isset($this->CoreFonts[$fontkey])) {
				if (in_array($family, $this->serif_fonts)) {
					$family = 'ctimes';
				} elseif (in_array($family, $this->mono_fonts)) {
					$family = 'ccourier';
				} else {
					$family = 'chelvetica';
				}
				$this->usingCoreFont = true;
				$fontkey = $family . $style;
			}

			if (!isset($this->fonts[$fontkey])) {
				// STANDARD CORE FONTS
				if (isset($this->CoreFonts[$fontkey])) {
					//Load metric file
					$file = $family;
					if ($family == 'ctimes' || $family == 'chelvetica' || $family == 'ccourier') {
						$file.=strtolower($style);
					}
					$file.='.php';
					include(_MPDF_PATH . 'font/' . $file);
					if (!isset($cw)) {
						throw new MpdfException('Could not include font metric file');
					}
					$i = count($this->fonts) + $this->extraFontSubsets + 1;
					$this->fonts[$fontkey] = array('i' => $i, 'type' => 'core', 'name' => $this->CoreFonts[$fontkey], 'desc' => $desc, 'up' => $up, 'ut' => $ut, 'cw' => $cw);
					if ($this->useKerning && isset($kerninfo)) {
						$this->fonts[$fontkey]['kerninfo'] = $kerninfo;
					}
				} else {
					throw new MpdfException('mPDF error - Font not defined');
				}
			}
			//Test if font is already selected
			if (($this->FontFamily == $family) AND ( $this->FontStyle == $style) AND ( $this->FontSizePt == $size) && !$forcewrite) {
				return $family;
			}
			//Select it
			$this->FontFamily = $family;
			$this->FontStyle = $style;
			$this->FontSizePt = $size;
			$this->FontSize = $size / _MPDFK;
			$this->CurrentFont = &$this->fonts[$fontkey];
			if ($write) {
				$fontout = (sprintf('BT /F%d %.3F Tf ET', $this->CurrentFont['i'], $this->FontSizePt));
				if ($this->page > 0 && ((isset($this->pageoutput[$this->page]['Font']) && $this->pageoutput[$this->page]['Font'] != $fontout) || !isset($this->pageoutput[$this->page]['Font']))) {
					$this->_out($fontout);
				}
				$this->pageoutput[$this->page]['Font'] = $fontout;
			}
			// Added - currentfont (lowercase) used in HTML2PDF
			$this->currentfontfamily = $family;
			$this->currentfontsize = $size;
			$this->currentfontstyle = $style;
		}

		return $family;
	}

	function SetFontSize($size, $write = true)
	{
		//Set font size in points
		if ($this->FontSizePt == $size)
			return;
		$this->FontSizePt = $size;
		$this->FontSize = $size / _MPDFK;
		$this->currentfontsize = $size;
		if ($write) {
			$fontout = (sprintf('BT /F%d %.3F Tf ET', $this->CurrentFont['i'], $this->FontSizePt));
			// Edited mPDF 3.0
			if ($this->page > 0 && ((isset($this->pageoutput[$this->page]['Font']) && $this->pageoutput[$this->page]['Font'] != $fontout) || !isset($this->pageoutput[$this->page]['Font']))) {
				$this->_out($fontout);
			}
			$this->pageoutput[$this->page]['Font'] = $fontout;
		}
	}

	function AddLink()
	{
		//Create a new internal link
		$n = count($this->links) + 1;
		$this->links[$n] = array(0, 0);
		return $n;
	}

	function SetLink($link, $y = 0, $page = -1)
	{
		//Set destination of internal link
		if ($y == -1)
			$y = $this->y;
		if ($page == -1)
			$page = $this->page;
		$this->links[$link] = array($page, $y);
	}

	function Link($x, $y, $w, $h, $link)
	{
		$l = array($x * _MPDFK, $this->hPt - $y * _MPDFK, $w * _MPDFK, $h * _MPDFK, $link);
		if ($this->keep_block_together) { // don't write yet
			return;
		} elseif ($this->table_rotate) { // *TABLES*
			$this->tbrot_Links[$this->page][] = $l; // *TABLES*
			return; // *TABLES*
		} // *TABLES*
		elseif ($this->kwt) {
			$this->kwt_Links[$this->page][] = $l;
			return;
		}

		if ($this->writingHTMLheader || $this->writingHTMLfooter) {
			$this->HTMLheaderPageLinks[] = $l;
			return;
		}
		//Put a link on the page
		$this->PageLinks[$this->page][] = $l;
		// Save cross-reference to Column buffer
		$ref = count($this->PageLinks[$this->page]) - 1; // *COLUMNS*
		$this->columnLinks[$this->CurrCol][INTVAL($this->x)][INTVAL($this->y)] = $ref; // *COLUMNS*
	}

	function Text($x, $y, $txt, $OTLdata = array(), $textvar = 0, $aixextra = '', $coordsys = '', $return = false)
	{
		// Output (or return) a string
		// Called (internally) by Watermark() & _tableWrite() [rotated cells] & TableHeaderFooter() & WriteText()
		// Called also from classes/svg.php
		// Expects Font to be set
		// Expects input to be mb_encoded if necessary and RTL reversed & OTL processed
		// ARTIFICIAL BOLD AND ITALIC
		$s = 'q ';
		if ($this->falseBoldWeight && strpos($this->ReqFontStyle, "B") !== false && strpos($this->FontStyle, "B") === false) {
			$s .= '2 Tr 1 J 1 j ';
			$s .= sprintf('%.3F w ', ($this->FontSize / 130) * _MPDFK * $this->falseBoldWeight);
			$tc = strtoupper($this->TextColor); // change 0 0 0 rg to 0 0 0 RG
			if ($this->FillColor != $tc) {
				$s .= $tc . ' ';
			}  // stroke (outline) = same colour as text(fill)
		}
		if (strpos($this->ReqFontStyle, "I") !== false && strpos($this->FontStyle, "I") === false) {
			$aix = '1 0 0.261799 1 %.3F %.3F Tm';
		} else {
			$aix = '%.3F %.3F Td';
		}

		$aix = $aixextra . $aix;

		if ($this->ColorFlag)
			$s.=$this->TextColor . ' ';

		$this->CurrentFont['used'] = true;

		if ($this->usingCoreFont) {
			$txt2 = str_replace(chr(160), chr(32), $txt);
		} else {
			$txt2 = str_replace(chr(194) . chr(160), chr(32), $txt);
		}

		$px = $x;
		$py = $y;
		if ($coordsys != 'SVG') {
			$px = $x * _MPDFK;
			$py = ($this->h - $y) * _MPDFK;
		}


		/*         * ************** SIMILAR TO Cell() ************************ */

		// IF corefonts AND NOT SmCaps AND NOT Kerning
		// Just output text
		if ($this->usingCoreFont && !($textvar & FC_SMALLCAPS) && !($textvar & FC_KERNING)) {
			$txt2 = $this->_escape($txt2);
			$s .=sprintf('BT ' . $aix . ' (%s) Tj ET', $px, $py, $txt2);
		}


		// IF NOT corefonts [AND NO wordspacing] AND NOT SIP/SMP AND NOT SmCaps AND NOT Kerning AND NOT OTL
		// Just output text
		elseif (!$this->usingCoreFont && !($textvar & FC_SMALLCAPS) && !($textvar & FC_KERNING) && !(isset($this->CurrentFont['useOTL']) && ($this->CurrentFont['useOTL'] & 0xFF) && !empty($OTLdata['GPOSinfo']))) {
			// IF SIP/SMP
			if ($this->CurrentFont['sip'] || $this->CurrentFont['smp']) {
				$txt2 = $this->UTF8toSubset($txt2);
				$s .=sprintf('BT ' . $aix . ' %s Tj ET', $px, $py, $txt2);
			}
			// NOT SIP/SMP
			else {
				$txt2 = $this->UTF8ToUTF16BE($txt2, false);
				$txt2 = $this->_escape($txt2);
				$s .=sprintf('BT ' . $aix . ' (%s) Tj ET', $px, $py, $txt2);
			}
		}

		// IF NOT corefonts [AND IS wordspacing] AND NOT SIP AND NOT SmCaps AND NOT Kerning AND NOT OTL
		// Not required here (cf. Cell() )
		// ELSE (IF SmCaps || Kerning || OTL) [corefonts or not corefonts; SIP or SMP or BMP]
		else {
			$s .= $this->applyGPOSpdf($txt2, $aix, $px, $py, $OTLdata, $textvar);
		}
		/*         * ************** END ************************ */

		$s .= ' ';

		if (($textvar & FD_UNDERLINE) && $txt != '') { // mPDF 5.7.1
			$c = strtoupper($this->TextColor); // change 0 0 0 rg to 0 0 0 RG
			if ($this->FillColor != $c) {
				$s.= ' ' . $c . ' ';
			}
			if (isset($this->CurrentFont['up']) && $this->CurrentFont['up']) {
				$up = $this->CurrentFont['up'];
			} else {
				$up = -100;
			}
			$adjusty = (-$up / 1000 * $this->FontSize);
			if (isset($this->CurrentFont['ut']) && $this->CurrentFont['ut']) {
				$ut = $this->CurrentFont['ut'] / 1000 * $this->FontSize;
			} else {
				$ut = 60 / 1000 * $this->FontSize;
			}
			$olw = $this->LineWidth;
			$s.=' ' . (sprintf(' %.3F w', $ut * _MPDFK));
			$s.=' ' . $this->_dounderline($x, $y + $adjusty, $txt, $OTLdata, $textvar);
			$s.=' ' . (sprintf(' %.3F w', $olw * _MPDFK));
			if ($this->FillColor != $c) {
				$s.= ' ' . $this->FillColor . ' ';
			}
		}
		// STRIKETHROUGH
		if (($textvar & FD_LINETHROUGH) && $txt != '') { // mPDF 5.7.1
			$c = strtoupper($this->TextColor); // change 0 0 0 rg to 0 0 0 RG
			if ($this->FillColor != $c) {
				$s.= ' ' . $c . ' ';
			}
			//Superscript and Subscript Y coordinate adjustment (now for striked-through texts)
			if (isset($this->CurrentFont['desc']['CapHeight']) && $this->CurrentFont['desc']['CapHeight']) {
				$ch = $this->CurrentFont['desc']['CapHeight'];
			} else {
				$ch = 700;
			}
			$adjusty = (-$ch / 1000 * $this->FontSize) * 0.35;
			if (isset($this->CurrentFont['ut']) && $this->CurrentFont['ut']) {
				$ut = $this->CurrentFont['ut'] / 1000 * $this->FontSize;
			} else {
				$ut = 60 / 1000 * $this->FontSize;
			}
			$olw = $this->LineWidth;
			$s.=' ' . (sprintf(' %.3F w', $ut * _MPDFK));
			$s.=' ' . $this->_dounderline($x, $y + $adjusty, $txt, $OTLdata, $textvar);
			$s.=' ' . (sprintf(' %.3F w', $olw * _MPDFK));
			if ($this->FillColor != $c) {
				$s.= ' ' . $this->FillColor . ' ';
			}
		}
		$s .= 'Q';

		if ($return) {
			return $s . " \n";
		}
		$this->_out($s);
	}

	/* -- DIRECTW -- */

	function WriteText($x, $y, $txt)
	{
		// Output a string using Text() but does encoding and text reversing of RTL
		$txt = $this->purify_utf8_text($txt);
		if ($this->text_input_as_HTML) {
			$txt = $this->all_entities_to_utf8($txt);
		}
		if ($this->usingCoreFont) {
			$txt = mb_convert_encoding($txt, $this->mb_enc, 'UTF-8');
		}

		// DIRECTIONALITY
		if (preg_match("/([" . $this->pregRTLchars . "])/u", $txt)) {
			$this->biDirectional = true;
		} // *OTL*

		$textvar = 0;
		$save_OTLtags = $this->OTLtags;
		$this->OTLtags = array();
		if ($this->useKerning) {
			if ($this->CurrentFont['haskernGPOS']) {
				$this->OTLtags['Plus'] .= ' kern';
			} else {
				$textvar = ($textvar | FC_KERNING);
			}
		}

		/* -- OTL -- */
		// Use OTL OpenType Table Layout - GSUB & GPOS
		if (isset($this->CurrentFont['useOTL']) && $this->CurrentFont['useOTL']) {
			$txt = $this->otl->applyOTL($txt, $this->CurrentFont['useOTL']);
			$OTLdata = $this->otl->OTLdata;
		}
		/* -- END OTL -- */
		$this->OTLtags = $save_OTLtags;

		$this->magic_reverse_dir($txt, $this->directionality, $OTLdata);

		$this->Text($x, $y, $txt, $OTLdata, $textvar);
	}

	function WriteCell($w, $h = 0, $txt = '', $border = 0, $ln = 0, $align = '', $fill = 0, $link = '', $currentx = 0)
	{
		//Output a cell using Cell() but does encoding and text reversing of RTL
		$txt = $this->purify_utf8_text($txt);
		if ($this->text_input_as_HTML) {
			$txt = $this->all_entities_to_utf8($txt);
		}
		if ($this->usingCoreFont) {
			$txt = mb_convert_encoding($txt, $this->mb_enc, 'UTF-8');
		}
		// DIRECTIONALITY
		if (preg_match("/([" . $this->pregRTLchars . "])/u", $txt)) {
			$this->biDirectional = true;
		} // *OTL*

		$textvar = 0;
		$save_OTLtags = $this->OTLtags;
		$this->OTLtags = array();
		if ($this->useKerning) {
			if ($this->CurrentFont['haskernGPOS']) {
				$this->OTLtags['Plus'] .= ' kern';
			} else {
				$textvar = ($textvar | FC_KERNING);
			}
		}

		/* -- OTL -- */
		// Use OTL OpenType Table Layout - GSUB & GPOS
		if (isset($this->CurrentFont['useOTL']) && $this->CurrentFont['useOTL']) {
			$txt = $this->otl->applyOTL($txt, $this->CurrentFont['useOTL']);
			$OTLdata = $this->otl->OTLdata;
		}
		/* -- END OTL -- */
		$this->OTLtags = $save_OTLtags;

		$this->magic_reverse_dir($txt, $this->directionality, $OTLdata);

		$this->Cell($w, $h, $txt, $border, $ln, $align, $fill, $link, $currentx, 0, 0, 'M', 0, false, $OTLdata, $textvar);
	}

	/* -- END DIRECTW -- */

	function ResetSpacing()
	{
		if ($this->ws != 0) {
			$this->_out('BT 0 Tw ET');
		}
		$this->ws = 0;
		if ($this->charspacing != 0) {
			$this->_out('BT 0 Tc ET');
		}
		$this->charspacing = 0;
	}

	function SetSpacing($cs, $ws)
	{
		if (intval($cs * 1000) == 0) {
			$cs = 0;
		}
		if ($cs) {
			$this->_out(sprintf('BT %.3F Tc ET', $cs));
		} elseif ($this->charspacing != 0) {
			$this->_out('BT 0 Tc ET');
		}
		$this->charspacing = $cs;
		if (intval($ws * 1000) == 0) {
			$ws = 0;
		}
		if ($ws) {
			$this->_out(sprintf('BT %.3F Tw ET', $ws));
		} elseif ($this->ws != 0) {
			$this->_out('BT 0 Tw ET');
		}
		$this->ws = $ws;
	}

	// WORD SPACING
	function GetJspacing($nc, $ns, $w, $inclCursive, &$cOTLdata)
	{
		$kashida_present = false;
		$kashida_space = 0;
		if ($w > 0 && $inclCursive && isset($this->CurrentFont['useKashida']) && $this->CurrentFont['useKashida'] && !empty($cOTLdata)) {
			for ($c = 0; $c < count($cOTLdata); $c++) {
				for ($i = 0; $i < strlen($cOTLdata[$c]['group']); $i++) {
					if (isset($cOTLdata[$c]['GPOSinfo'][$i]['kashida']) && $cOTLdata[$c]['GPOSinfo'][$i]['kashida'] > 0) {
						$kashida_present = true;
						break 2;
					}
				}
			}
		}

		if ($kashida_present) {
			$k_ctr = 0;  // Number of kashida points
			$k_total = 0;  // Total of kashida values (priority)
			// Reset word
			$max_kashida_in_word = 0;
			$last_kashida_in_word = -1;

			for ($c = 0; $c < count($cOTLdata); $c++) {
				for ($i = 0; $i < strlen($cOTLdata[$c]['group']); $i++) {

					if ($cOTLdata[$c]['group']{$i} == 'S') {
						// Save from last word
						if ($max_kashida_in_word) {
							$k_ctr++;
							$k_total = $max_kashida_in_word;
						}
						// Reset word
						$max_kashida_in_word = 0;
						$last_kashida_in_word = -1;
					}

					if (isset($cOTLdata[$c]['GPOSinfo'][$i]['kashida']) && $cOTLdata[$c]['GPOSinfo'][$i]['kashida'] > 0) {
						if ($max_kashida_in_word) {
							if ($cOTLdata[$c]['GPOSinfo'][$i]['kashida'] > $max_kashida_in_word) {
								$max_kashida_in_word = $cOTLdata[$c]['GPOSinfo'][$i]['kashida'];
								$cOTLdata[$c]['GPOSinfo'][$last_kashida_in_word]['kashida'] = 0;
								$last_kashida_in_word = $i;
							} else {
								$cOTLdata[$c]['GPOSinfo'][$i]['kashida'] = 0;
							}
						} else {
							$max_kashida_in_word = $cOTLdata[$c]['GPOSinfo'][$i]['kashida'];
							$last_kashida_in_word = $i;
						}
					}
				}
			}
			// Save from last word
			if ($max_kashida_in_word) {
				$k_ctr++;
				$k_total = $max_kashida_in_word;
			}

			// Number of kashida points = $k_ctr
			// $useKashida is a % value from CurrentFont/config_fonts.php
			// % ratio divided between word-spacing and kashida-spacing
			$kashida_space_ratio = intval($this->CurrentFont['useKashida']) / 100;


			$kashida_space = $w * $kashida_space_ratio;

			$tatw = $this->_getCharWidth($this->CurrentFont['cw'], 0x0640);
			// Only use kashida if each allocated kashida width is > 0.01 x width of a tatweel
			// Otherwise fontstretch is too small and errors
			// If not just leave to adjust word-spacing
			if ($tatw && (($kashida_space / $k_ctr) / $tatw) > 0.01) {
				for ($c = 0; $c < count($cOTLdata); $c++) {
					for ($i = 0; $i < strlen($cOTLdata[$c]['group']); $i++) {
						if (isset($cOTLdata[$c]['GPOSinfo'][$i]['kashida']) && $cOTLdata[$c]['GPOSinfo'][$i]['kashida'] > 0) {
							// At this point kashida is a number representing priority (higher number - higher priority)
							// We are now going to set it as an actual length
							// This shares it equally amongst words:
							$cOTLdata[$c]['GPOSinfo'][$i]['kashida_space'] = (1 / $k_ctr) * $kashida_space;
						}
					}
				}
				$w -= $kashida_space;
			}
		}

		$ws = 0;
		$charspacing = 0;
		$ww = $this->jSWord;
		$ncx = $nc - 1;
		if ($nc == 0) {
			return array(0, 0, 0);
		}
		// Only word spacing allowed / possible
		elseif ($this->fixedlSpacing !== false || $inclCursive) {
			if ($ns) {
				$ws = $w / $ns;
			}
		} elseif ($nc == 1) {
			$charspacing = $w;
		} elseif (!$ns) {
			$charspacing = $w / ($ncx );
			if (($this->jSmaxChar > 0) && ($charspacing > $this->jSmaxChar)) {
				$charspacing = $this->jSmaxChar;
			}
		} elseif ($ns == ($ncx )) {
			$charspacing = $w / $ns;
		} else {
			if ($this->usingCoreFont) {
				$cs = ($w * (1 - $this->jSWord)) / ($ncx );
				if (($this->jSmaxChar > 0) && ($cs > $this->jSmaxChar)) {
					$cs = $this->jSmaxChar;
					$ww = 1 - (($cs * ($ncx )) / $w);
				}
				$charspacing = $cs;
				$ws = ($w * ($ww) ) / $ns;
			} else {
				$cs = ($w * (1 - $this->jSWord)) / ($ncx - $ns);
				if (($this->jSmaxChar > 0) && ($cs > $this->jSmaxChar)) {
					$cs = $this->jSmaxChar;
					$ww = 1 - (($cs * ($ncx - $ns)) / $w);
				}
				$charspacing = $cs;
				$ws = (($w * ($ww) ) / $ns) - $charspacing;
			}
		}
		return array($charspacing, $ws, $kashida_space);
	}

	function Cell($w, $h = 0, $txt = '', $border = 0, $ln = 0, $align = '', $fill = 0, $link = '', $currentx = 0, $lcpaddingL = 0, $lcpaddingR = 0, $valign = 'M', $spanfill = 0, $exactWidth = false, $OTLdata = false, $textvar = 0, $lineBox = false)
	{  // mPDF 5.7.1
		//Output a cell
		// Expects input to be mb_encoded if necessary and RTL reversed
		// NON_BREAKING SPACE
		if ($this->usingCoreFont) {
			$txt = str_replace(chr(160), chr(32), $txt);
		} else {
			$txt = str_replace(chr(194) . chr(160), chr(32), $txt);
		}

		$oldcolumn = $this->CurrCol;
		// Automatic page break
		// Allows PAGE-BREAK-AFTER = avoid to work
		if (isset($this->blk[$this->blklvl])) {
			$bottom = $this->blk[$this->blklvl]['padding_bottom'] + $this->blk[$this->blklvl]['margin_bottom'];
		} else {
			$bottom = 0;
		}
		if (!$this->tableLevel && (($this->y + $this->divheight > $this->PageBreakTrigger) || ($this->y + $h > $this->PageBreakTrigger) ||
			($this->y + ($h * 2) + $bottom > $this->PageBreakTrigger && $this->blk[$this->blklvl]['page_break_after_avoid'])) and ! $this->InFooter and $this->AcceptPageBreak()) { // mPDF 5.7.2
			$x = $this->x; //Current X position
			// WORD SPACING
			$ws = $this->ws; //Word Spacing
			$charspacing = $this->charspacing; //Character Spacing
			$this->ResetSpacing();

			$this->AddPage($this->CurOrientation);
			// Added to correct for OddEven Margins
			$x += $this->MarginCorrection;
			if ($currentx) {
				$currentx += $this->MarginCorrection;
			}
			$this->x = $x;
			// WORD SPACING
			$this->SetSpacing($charspacing, $ws);
		}

		// Test: to put line through centre of cell: $this->Line($this->x,$this->y+($h/2),$this->x+50,$this->y+($h/2));
		// Test: to put border around cell as it is specified: $border='LRTB';


		/* -- COLUMNS -- */
		// COLS
		// COLUMN CHANGE
		if ($this->CurrCol != $oldcolumn) {
			if ($currentx) {
				$currentx += $this->ChangeColumn * ($this->ColWidth + $this->ColGap);
			}
			$this->x += $this->ChangeColumn * ($this->ColWidth + $this->ColGap);
		}

		// COLUMNS Update/overwrite the lowest bottom of printing y value for a column
		if ($this->ColActive) {
			if ($h) {
				$this->ColDetails[$this->CurrCol]['bottom_margin'] = $this->y + $h;
			} else {
				$this->ColDetails[$this->CurrCol]['bottom_margin'] = $this->y + $this->divheight;
			}
		}
		/* -- END COLUMNS -- */


		if ($w == 0)
			$w = $this->w - $this->rMargin - $this->x;
		$s = '';
		if ($fill == 1 && $this->FillColor) {
			if ((isset($this->pageoutput[$this->page]['FillColor']) && $this->pageoutput[$this->page]['FillColor'] != $this->FillColor) || !isset($this->pageoutput[$this->page]['FillColor'])) {
				$s .= $this->FillColor . ' ';
			}
			$this->pageoutput[$this->page]['FillColor'] = $this->FillColor;
		}


		if ($lineBox && isset($lineBox['boxtop']) && $txt) { // i.e. always from WriteFlowingBlock/finishFlowingBlock (but not objects -
			// which only have $lineBox['top'] set)
			$boxtop = $this->y + $lineBox['boxtop'];
			$boxbottom = $this->y + $lineBox['boxbottom'];
			$glyphYorigin = $lineBox['glyphYorigin'];
			$baseline_shift = $lineBox['baseline-shift'];
			$bord_boxtop = $bg_boxtop = $boxtop = $boxtop - $baseline_shift;
			$bord_boxbottom = $bg_boxbottom = $boxbottom = $boxbottom - $baseline_shift;
			$bord_boxheight = $bg_boxheight = $boxheight = $boxbottom - $boxtop;

			// If inline element BACKGROUND has bounding box set by parent element:
			if (isset($lineBox['background-boxtop'])) {
				$bg_boxtop = $this->y + $lineBox['background-boxtop'] - $lineBox['background-baseline-shift'];
				$bg_boxbottom = $this->y + $lineBox['background-boxbottom'] - $lineBox['background-baseline-shift'];
				$bg_boxheight = $bg_boxbottom - $bg_boxtop;
			}
			// If inline element BORDER has bounding box set by parent element:
			if (isset($lineBox['border-boxtop'])) {
				$bord_boxtop = $this->y + $lineBox['border-boxtop'] - $lineBox['border-baseline-shift'];
				$bord_boxbottom = $this->y + $lineBox['border-boxbottom'] - $lineBox['border-baseline-shift'];
				$bord_boxheight = $bord_boxbottom - $bord_boxtop;
			}
		} else {
			$boxtop = $this->y;
			$boxheight = $h;
			$boxbottom = $this->y + $h;
			$baseline_shift = 0;
			if ($txt != '') {
				// FONT SIZE - this determines the baseline caculation
				$bfs = $this->FontSize;
				//Calculate baseline Superscript and Subscript Y coordinate adjustment
				$bfx = $this->baselineC;
				$baseline = $bfx * $bfs;

				if ($textvar & FA_SUPERSCRIPT) {
					$baseline_shift = $this->textparam['text-baseline'];
				} // mPDF 5.7.1	// mPDF 6
				elseif ($textvar & FA_SUBSCRIPT) {
					$baseline_shift = $this->textparam['text-baseline'];
				} // mPDF 5.7.1	// mPDF 6
				elseif ($this->bullet) {
					$baseline += ($bfx - 0.7) * $this->FontSize;
				}

				// Vertical align (for Images)
				if ($valign == 'T') {
					$va = (0.5 * $bfs * $this->normalLineheight);
				} elseif ($valign == 'B') {
					$va = $h - (0.5 * $bfs * $this->normalLineheight);
				} else {
					$va = 0.5 * $h;
				} // Middle
				// ONLY SET THESE IF WANT TO CONFINE BORDER +/- FILL TO FIT FONTSIZE - NOT FULL CELL AS IS ORIGINAL FUNCTION
				// spanfill or spanborder are set in FlowingBlock functions
				if ($spanfill || !empty($this->spanborddet) || $link != '') {
					$exth = 0.2; // Add to fontsize to increase height of background / link / border
					$boxtop = $this->y + $baseline + $va - ($this->FontSize * (1 + $exth / 2) * (0.5 + $bfx));
					$boxheight = $this->FontSize * (1 + $exth);
					$boxbottom = $boxtop + $boxheight;
				}
				$glyphYorigin = $baseline + $va;
			}
			$boxtop -= $baseline_shift;
			$boxbottom -= $baseline_shift;
			$bord_boxtop = $bg_boxtop = $boxtop;
			$bord_boxbottom = $bg_boxbottom = $boxbottom;
			$bord_boxheight = $bg_boxheight = $boxheight = $boxbottom - $boxtop;
		}


		$bbw = $tbw = $lbw = $rbw = 0; // Border widths
		if (!empty($this->spanborddet)) {
			if (!isset($this->spanborddet['B'])) {
				$this->spanborddet['B'] = array('s' => 0, 'style' => '', 'w' => 0);
			}
			if (!isset($this->spanborddet['T'])) {
				$this->spanborddet['T'] = array('s' => 0, 'style' => '', 'w' => 0);
			}
			if (!isset($this->spanborddet['L'])) {
				$this->spanborddet['L'] = array('s' => 0, 'style' => '', 'w' => 0);
			}
			if (!isset($this->spanborddet['R'])) {
				$this->spanborddet['R'] = array('s' => 0, 'style' => '', 'w' => 0);
			}
			$bbw = $this->spanborddet['B']['w'];
			$tbw = $this->spanborddet['T']['w'];
			$lbw = $this->spanborddet['L']['w'];
			$rbw = $this->spanborddet['R']['w'];
		}
		if ($fill == 1 || $border == 1 || !empty($this->spanborddet)) {
			if (!empty($this->spanborddet)) {
				if ($fill == 1) {
					$s.=sprintf('%.3F %.3F %.3F %.3F re f ', ($this->x - $lbw) * _MPDFK, ($this->h - $bg_boxtop + $tbw) * _MPDFK, ($w + $lbw + $rbw) * _MPDFK, (-$bg_boxheight - $tbw - $bbw) * _MPDFK);
				}
				$s.= ' q ';
				$dashon = 3;
				$dashoff = 3.5;
				$dot = 2.5;
				if ($tbw) {
					$short = 0;
					if ($this->spanborddet['T']['style'] == 'dashed') {
						$s.=sprintf(' 0 j 0 J [%.3F %.3F] 0 d ', $tbw * $dashon * _MPDFK, $tbw * $dashoff * _MPDFK);
					} elseif ($this->spanborddet['T']['style'] == 'dotted') {
						$s.=sprintf(' 1 j 1 J [%.3F %.3F] %.3F d ', 0.001, $tbw * $dot * _MPDFK, -$tbw / 2 * _MPDFK);
						$short = $tbw / 2;
					} else {
						$s.=' 0 j 0 J [] 0 d ';
					}
					if ($this->spanborddet['T']['style'] != 'dotted') {
						$s .= 'q ';
						$s .= sprintf('%.3F %.3F m ', ($this->x - $lbw) * _MPDFK, ($this->h - $bord_boxtop + $tbw) * _MPDFK);
						$s .= sprintf('%.3F %.3F l ', ($this->x + $w + $rbw) * _MPDFK, ($this->h - $bord_boxtop + $tbw) * _MPDFK);
						$s .= sprintf('%.3F %.3F l ', ($this->x + $w) * _MPDFK, ($this->h - $bord_boxtop) * _MPDFK);
						$s .= sprintf('%.3F %.3F l ', ($this->x) * _MPDFK, ($this->h - $bord_boxtop) * _MPDFK);
						$s .= ' h W n '; // Ends path no-op & Sets the clipping path
					}
					$c = $this->SetDColor($this->spanborddet['T']['c'], true);
					if ($this->spanborddet['T']['style'] == 'double') {
						$s.=sprintf(' %s %.3F w ', $c, $tbw / 3 * _MPDFK);
						$s.=sprintf('%.3F %.3F m %.3F %.3F l S ', ($this->x - $lbw) * _MPDFK, ($this->h - $bord_boxtop + $tbw * 5 / 6) * _MPDFK, ($this->x + $w + $rbw) * _MPDFK, ($this->h - $bord_boxtop + $tbw * 5 / 6) * _MPDFK);
						$s.=sprintf('%.3F %.3F m %.3F %.3F l S ', ($this->x - $lbw) * _MPDFK, ($this->h - $bord_boxtop + $tbw / 6) * _MPDFK, ($this->x + $w + $rbw) * _MPDFK, ($this->h - $bord_boxtop + $tbw / 6) * _MPDFK);
					} elseif ($this->spanborddet['T']['style'] == 'dotted') {
						$s.=sprintf(' %s %.3F w ', $c, $tbw * _MPDFK);
						$s.=sprintf('%.3F %.3F m %.3F %.3F l S ', ($this->x - $lbw) * _MPDFK, ($this->h - $bord_boxtop + $tbw / 2) * _MPDFK, ($this->x + $w + $rbw - $short) * _MPDFK, ($this->h - $bord_boxtop + $tbw / 2) * _MPDFK);
					} else {
						$s.=sprintf(' %s %.3F w ', $c, $tbw * _MPDFK);
						$s.=sprintf('%.3F %.3F m %.3F %.3F l S ', ($this->x - $lbw) * _MPDFK, ($this->h - $bord_boxtop + $tbw / 2) * _MPDFK, ($this->x + $w + $rbw - $short) * _MPDFK, ($this->h - $bord_boxtop + $tbw / 2) * _MPDFK);
					}
					if ($this->spanborddet['T']['style'] != 'dotted') {
						$s .= ' Q ';
					}
				}
				if ($bbw) {
					$short = 0;
					if ($this->spanborddet['B']['style'] == 'dashed') {
						$s.=sprintf(' 0 j 0 J [%.3F %.3F] 0 d ', $bbw * $dashon * _MPDFK, $bbw * $dashoff * _MPDFK);
					} elseif ($this->spanborddet['B']['style'] == 'dotted') {
						$s.=sprintf(' 1 j 1 J [%.3F %.3F] %.3F d ', 0.001, $bbw * $dot * _MPDFK, -$bbw / 2 * _MPDFK);
						$short = $bbw / 2;
					} else {
						$s.=' 0 j 0 J [] 0 d ';
					}
					if ($this->spanborddet['B']['style'] != 'dotted') {
						$s .= 'q ';
						$s .= sprintf('%.3F %.3F m ', ($this->x - $lbw) * _MPDFK, ($this->h - $bord_boxbottom - $bbw) * _MPDFK);
						$s .= sprintf('%.3F %.3F l ', ($this->x + $w + $rbw) * _MPDFK, ($this->h - $bord_boxbottom - $bbw) * _MPDFK);
						$s .= sprintf('%.3F %.3F l ', ($this->x + $w) * _MPDFK, ($this->h - $bord_boxbottom) * _MPDFK);
						$s .= sprintf('%.3F %.3F l ', ($this->x) * _MPDFK, ($this->h - $bord_boxbottom) * _MPDFK);
						$s .= ' h W n '; // Ends path no-op & Sets the clipping path
					}
					$c = $this->SetDColor($this->spanborddet['B']['c'], true);
					if ($this->spanborddet['B']['style'] == 'double') {
						$s.=sprintf(' %s %.3F w ', $c, $bbw / 3 * _MPDFK);
						$s.=sprintf('%.3F %.3F m %.3F %.3F l S ', ($this->x - $lbw) * _MPDFK, ($this->h - $bord_boxbottom - $bbw / 6) * _MPDFK, ($this->x + $w + $rbw - $short) * _MPDFK, ($this->h - $bord_boxbottom - $bbw / 6) * _MPDFK);
						$s.=sprintf('%.3F %.3F m %.3F %.3F l S ', ($this->x - $lbw) * _MPDFK, ($this->h - $bord_boxbottom - $bbw * 5 / 6) * _MPDFK, ($this->x + $w + $rbw - $short) * _MPDFK, ($this->h - $bord_boxbottom - $bbw * 5 / 6) * _MPDFK);
					} elseif ($this->spanborddet['B']['style'] == 'dotted') {
						$s.=sprintf(' %s %.3F w ', $c, $bbw * _MPDFK);
						$s.=sprintf('%.3F %.3F m %.3F %.3F l S ', ($this->x - $lbw) * _MPDFK, ($this->h - $bord_boxbottom - $bbw / 2) * _MPDFK, ($this->x + $w + $rbw - $short) * _MPDFK, ($this->h - $bord_boxbottom - $bbw / 2) * _MPDFK);
					} else {
						$s.=sprintf(' %s %.3F w ', $c, $bbw * _MPDFK);
						$s.=sprintf('%.3F %.3F m %.3F %.3F l S ', ($this->x - $lbw) * _MPDFK, ($this->h - $bord_boxbottom - $bbw / 2) * _MPDFK, ($this->x + $w + $rbw - $short) * _MPDFK, ($this->h - $bord_boxbottom - $bbw / 2) * _MPDFK);
					}
					if ($this->spanborddet['B']['style'] != 'dotted') {
						$s .= ' Q ';
					}
				}
				if ($lbw) {
					$short = 0;
					if ($this->spanborddet['L']['style'] == 'dashed') {
						$s.=sprintf(' 0 j 0 J [%.3F %.3F] 0 d ', $lbw * $dashon * _MPDFK, $lbw * $dashoff * _MPDFK);
					} elseif ($this->spanborddet['L']['style'] == 'dotted') {
						$s.=sprintf(' 1 j 1 J [%.3F %.3F] %.3F d ', 0.001, $lbw * $dot * _MPDFK, -$lbw / 2 * _MPDFK);
						$short = $lbw / 2;
					} else {
						$s.=' 0 j 0 J [] 0 d ';
					}
					if ($this->spanborddet['L']['style'] != 'dotted') {
						$s .= 'q ';
						$s .= sprintf('%.3F %.3F m ', ($this->x - $lbw) * _MPDFK, ($this->h - $bord_boxbottom - $bbw) * _MPDFK);
						$s .= sprintf('%.3F %.3F l ', ($this->x) * _MPDFK, ($this->h - $bord_boxbottom) * _MPDFK);
						$s .= sprintf('%.3F %.3F l ', ($this->x) * _MPDFK, ($this->h - $bord_boxtop) * _MPDFK);
						$s .= sprintf('%.3F %.3F l ', ($this->x - $lbw) * _MPDFK, ($this->h - $bord_boxtop + $tbw) * _MPDFK);
						$s .= ' h W n '; // Ends path no-op & Sets the clipping path
					}
					$c = $this->SetDColor($this->spanborddet['L']['c'], true);
					if ($this->spanborddet['L']['style'] == 'double') {
						$s.=sprintf(' %s %.3F w ', $c, $lbw / 3 * _MPDFK);
						$s.=sprintf('%.3F %.3F m %.3F %.3F l S ', ($this->x - $lbw / 6) * _MPDFK, ($this->h - $bord_boxtop + $tbw) * _MPDFK, ($this->x - $lbw / 6) * _MPDFK, ($this->h - $bord_boxbottom - $bbw + $short) * _MPDFK);
						$s.=sprintf('%.3F %.3F m %.3F %.3F l S ', ($this->x - $lbw * 5 / 6) * _MPDFK, ($this->h - $bord_boxtop + $tbw) * _MPDFK, ($this->x - $lbw * 5 / 6) * _MPDFK, ($this->h - $bord_boxbottom - $bbw + $short) * _MPDFK);
					} elseif ($this->spanborddet['L']['style'] == 'dotted') {
						$s.=sprintf(' %s %.3F w ', $c, $lbw * _MPDFK);
						$s.=sprintf('%.3F %.3F m %.3F %.3F l S ', ($this->x - $lbw / 2) * _MPDFK, ($this->h - $bord_boxtop + $tbw) * _MPDFK, ($this->x - $lbw / 2) * _MPDFK, ($this->h - $bord_boxbottom - $bbw + $short) * _MPDFK);
					} else {
						$s.=sprintf(' %s %.3F w ', $c, $lbw * _MPDFK);
						$s.=sprintf('%.3F %.3F m %.3F %.3F l S ', ($this->x - $lbw / 2) * _MPDFK, ($this->h - $bord_boxtop + $tbw) * _MPDFK, ($this->x - $lbw / 2) * _MPDFK, ($this->h - $bord_boxbottom - $bbw + $short) * _MPDFK);
					}
					if ($this->spanborddet['L']['style'] != 'dotted') {
						$s .= ' Q ';
					}
				}
				if ($rbw) {
					$short = 0;
					if ($this->spanborddet['R']['style'] == 'dashed') {
						$s.=sprintf(' 0 j 0 J [%.3F %.3F] 0 d ', $rbw * $dashon * _MPDFK, $rbw * $dashoff * _MPDFK);
					} elseif ($this->spanborddet['R']['style'] == 'dotted') {
						$s.=sprintf(' 1 j 1 J [%.3F %.3F] %.3F d ', 0.001, $rbw * $dot * _MPDFK, -$rbw / 2 * _MPDFK);
						$short = $rbw / 2;
					} else {
						$s.=' 0 j 0 J [] 0 d ';
					}
					if ($this->spanborddet['R']['style'] != 'dotted') {
						$s .= 'q ';
						$s .= sprintf('%.3F %.3F m ', ($this->x + $w + $rbw) * _MPDFK, ($this->h - $bord_boxbottom - $bbw) * _MPDFK);
						$s .= sprintf('%.3F %.3F l ', ($this->x + $w) * _MPDFK, ($this->h - $bord_boxbottom) * _MPDFK);
						$s .= sprintf('%.3F %.3F l ', ($this->x + $w) * _MPDFK, ($this->h - $bord_boxtop) * _MPDFK);
						$s .= sprintf('%.3F %.3F l ', ($this->x + $w + $rbw) * _MPDFK, ($this->h - $bord_boxtop + $tbw) * _MPDFK);
						$s .= ' h W n '; // Ends path no-op & Sets the clipping path
					}
					$c = $this->SetDColor($this->spanborddet['R']['c'], true);
					if ($this->spanborddet['R']['style'] == 'double') {
						$s.=sprintf(' %s %.3F w ', $c, $rbw / 3 * _MPDFK);
						$s.=sprintf('%.3F %.3F m %.3F %.3F l S ', ($this->x + $w + $rbw / 6) * _MPDFK, ($this->h - $bord_boxtop + $tbw) * _MPDFK, ($this->x + $w + $rbw / 6) * _MPDFK, ($this->h - $bord_boxbottom - $bbw + $short) * _MPDFK);
						$s.=sprintf('%.3F %.3F m %.3F %.3F l S ', ($this->x + $w + $rbw * 5 / 6) * _MPDFK, ($this->h - $bord_boxtop + $tbw) * _MPDFK, ($this->x + $w + $rbw * 5 / 6) * _MPDFK, ($this->h - $bord_boxbottom - $bbw + $short) * _MPDFK);
					} elseif ($this->spanborddet['R']['style'] == 'dotted') {
						$s.=sprintf(' %s %.3F w ', $c, $rbw * _MPDFK);
						$s.=sprintf('%.3F %.3F m %.3F %.3F l S ', ($this->x + $w + $rbw / 2) * _MPDFK, ($this->h - $bord_boxtop + $tbw) * _MPDFK, ($this->x + $w + $rbw / 2) * _MPDFK, ($this->h - $bord_boxbottom - $bbw + $short) * _MPDFK);
					} else {
						$s.=sprintf(' %s %.3F w ', $c, $rbw * _MPDFK);
						$s.=sprintf('%.3F %.3F m %.3F %.3F l S ', ($this->x + $w + $rbw / 2) * _MPDFK, ($this->h - $bord_boxtop + $tbw) * _MPDFK, ($this->x + $w + $rbw / 2) * _MPDFK, ($this->h - $bord_boxbottom - $bbw + $short) * _MPDFK);
					}
					if ($this->spanborddet['R']['style'] != 'dotted') {
						$s .= ' Q ';
					}
				}
				$s.= ' Q ';
			} else { // If "border", does not come from WriteFlowingBlock or FinishFlowingBlock
				if ($fill == 1)
					$op = ($border == 1) ? 'B' : 'f';
				else
					$op = 'S';
				$s.=sprintf('%.3F %.3F %.3F %.3F re %s ', $this->x * _MPDFK, ($this->h - $bg_boxtop) * _MPDFK, $w * _MPDFK, -$bg_boxheight * _MPDFK, $op);
			}
		}

		if (is_string($border)) { // If "border", does not come from WriteFlowingBlock or FinishFlowingBlock
			$x = $this->x;
			$y = $this->y;
			if (is_int(strpos($border, 'L')))
				$s.=sprintf('%.3F %.3F m %.3F %.3F l S ', $x * _MPDFK, ($this->h - $bord_boxtop) * _MPDFK, $x * _MPDFK, ($this->h - ($bord_boxbottom)) * _MPDFK);
			if (is_int(strpos($border, 'T')))
				$s.=sprintf('%.3F %.3F m %.3F %.3F l S ', $x * _MPDFK, ($this->h - $bord_boxtop) * _MPDFK, ($x + $w) * _MPDFK, ($this->h - $bord_boxtop) * _MPDFK);
			if (is_int(strpos($border, 'R')))
				$s.=sprintf('%.3F %.3F m %.3F %.3F l S ', ($x + $w) * _MPDFK, ($this->h - $bord_boxtop) * _MPDFK, ($x + $w) * _MPDFK, ($this->h - ($bord_boxbottom)) * _MPDFK);
			if (is_int(strpos($border, 'B')))
				$s.=sprintf('%.3F %.3F m %.3F %.3F l S ', $x * _MPDFK, ($this->h - ($bord_boxbottom)) * _MPDFK, ($x + $w) * _MPDFK, ($this->h - ($bord_boxbottom)) * _MPDFK);
		}

		if ($txt != '') {


			if ($exactWidth)
				$stringWidth = $w;
			else
				$stringWidth = $this->GetStringWidth($txt, true, $OTLdata, $textvar) + ( $this->charspacing * mb_strlen($txt, $this->mb_enc) / _MPDFK ) + ( $this->ws * mb_substr_count($txt, ' ', $this->mb_enc) / _MPDFK );

			// Set x OFFSET FOR PRINTING
			if ($align == 'R') {
				$dx = $w - $this->cMarginR - $stringWidth - $lcpaddingR;
			} elseif ($align == 'C') {
				$dx = (($w - $stringWidth ) / 2);
			} elseif ($align == 'L' or $align == 'J')
				$dx = $this->cMarginL + $lcpaddingL;
			else
				$dx = 0;

			if ($this->ColorFlag)
				$s .='q ' . $this->TextColor . ' ';

			// OUTLINE
			if (isset($this->textparam['outline-s']) && $this->textparam['outline-s'] && !($textvar & FC_SMALLCAPS)) { // mPDF 5.7.1
				$s .=' ' . sprintf('%.3F w', $this->LineWidth * _MPDFK) . ' ';
				$s .=" $this->DrawColor ";
				$s .=" 2 Tr ";
			} elseif ($this->falseBoldWeight && strpos($this->ReqFontStyle, "B") !== false && strpos($this->FontStyle, "B") === false && !($textvar & FC_SMALLCAPS)) { // can't use together with OUTLINE or Small Caps	// mPDF 5.7.1	??? why not with SmallCaps ???
				$s .= ' 2 Tr 1 J 1 j ';
				$s .= ' ' . sprintf('%.3F w', ($this->FontSize / 130) * _MPDFK * $this->falseBoldWeight) . ' ';
				$tc = strtoupper($this->TextColor); // change 0 0 0 rg to 0 0 0 RG
				if ($this->FillColor != $tc) {
					$s .= ' ' . $tc . ' ';
				}  // stroke (outline) = same colour as text(fill)
			} else {
				$s .=" 0 Tr ";
			}

			if (strpos($this->ReqFontStyle, "I") !== false && strpos($this->FontStyle, "I") === false) { // Artificial italic
				$aix = '1 0 0.261799 1 %.3F %.3F Tm ';
			} else {
				$aix = '%.3F %.3F Td ';
			}

			$px = ($this->x + $dx) * _MPDFK;
			$py = ($this->h - ($this->y + $glyphYorigin - $baseline_shift)) * _MPDFK;

			// THE TEXT
			$txt2 = $txt;
			$sub = '';
			$this->CurrentFont['used'] = true;

			/*             * ************** SIMILAR TO Text() ************************ */

			// IF corefonts AND NOT SmCaps AND NOT Kerning
			// Just output text; charspacing and wordspacing already set by charspacing (Tc) and ws (Tw)
			if ($this->usingCoreFont && !($textvar & FC_SMALLCAPS) && !($textvar & FC_KERNING)) {
				$txt2 = $this->_escape($txt2);
				$sub .=sprintf('BT ' . $aix . ' (%s) Tj ET', $px, $py, $txt2);
			}


			// IF NOT corefonts AND NO wordspacing AND NOT SIP/SMP AND NOT SmCaps AND NOT Kerning AND NOT OTL
			// Just output text
			elseif (!$this->usingCoreFont && !$this->ws && !($textvar & FC_SMALLCAPS) && !($textvar & FC_KERNING) && !(isset($this->CurrentFont['useOTL']) && ($this->CurrentFont['useOTL'] & 0xFF) && !empty($OTLdata['GPOSinfo']))) {
				// IF SIP/SMP
				if ((isset($this->CurrentFont['sip']) && $this->CurrentFont['sip']) || (isset($this->CurrentFont['smp']) && $this->CurrentFont['smp'])) {
					$txt2 = $this->UTF8toSubset($txt2);
					$sub .=sprintf('BT ' . $aix . ' %s Tj ET', $px, $py, $txt2);
				}
				// NOT SIP/SMP
				else {
					$txt2 = $this->UTF8ToUTF16BE($txt2, false);
					$txt2 = $this->_escape($txt2);
					$sub .=sprintf('BT ' . $aix . ' (%s) Tj ET', $px, $py, $txt2);
				}
			}


			// IF NOT corefonts AND IS wordspacing AND NOT SIP AND NOT SmCaps AND NOT Kerning AND NOT OTL
			// Output text word by word with an adjustment to the intercharacter spacing for SPACEs to form word spacing
			// IF multibyte - Tw has no effect - need to do word spacing using an adjustment before each space
			elseif (!$this->usingCoreFont && $this->ws && !((isset($this->CurrentFont['sip']) && $this->CurrentFont['sip']) || (isset($this->CurrentFont['smp']) && $this->CurrentFont['smp'])) && !($textvar & FC_SMALLCAPS) && !($textvar & FC_KERNING) && !(isset($this->CurrentFont['useOTL']) && ($this->CurrentFont['useOTL'] & 0xFF) && (!empty($OTLdata['GPOSinfo']) || (strpos($OTLdata['group'], 'M') !== false && $this->charspacing)) )) {
				$space = " ";
				$space = $this->UTF8ToUTF16BE($space, false);
				$space = $this->_escape($space);
				$sub .=sprintf('BT ' . $aix . ' %.3F Tc [', $px, $py, $this->charspacing);
				$t = explode(' ', $txt2);
				$numt = count($t);
				for ($i = 0; $i < $numt; $i++) {
					$tx = $t[$i];
					$tx = $this->UTF8ToUTF16BE($tx, false);
					$tx = $this->_escape($tx);
					$sub .=sprintf('(%s) ', $tx);
					if (($i + 1) < $numt) {
						$adj = -($this->ws) * 1000 / $this->FontSizePt;
						$sub .=sprintf('%d(%s) ', $adj, $space);
					}
				}
				$sub .='] TJ ';
				$sub .=' ET';
			}


			// ELSE (IF SmCaps || Kerning || OTL) [corefonts or not corefonts; SIP or SMP or BMP]
			else {
				$sub = $this->applyGPOSpdf($txt, $aix, $px, $py, $OTLdata, $textvar);
			}

			/*             * ************** END SIMILAR TO Text() ************************ */

			if ($this->shrin_k > 1) {
				$shrin_k = $this->shrin_k;
			} else {
				$shrin_k = 1;
			}
			// UNDERLINE
			if ($textvar & FD_UNDERLINE) { // mPDF 5.7.1	// mPDF 6
				// mPDF 5.7.3  inline text-decoration parameters
				$c = $this->textparam['u-decoration']['color'];
				if ($this->FillColor != $c) {
					$sub .= ' ' . $c . ' ';
				}
				// mPDF 5.7.3  inline text-decoration parameters
				$decorationfontkey = $this->textparam['u-decoration']['fontkey'];
				$decorationfontsize = $this->textparam['u-decoration']['fontsize'] / $shrin_k;
				if (isset($this->fonts[$decorationfontkey]['ut']) && $this->fonts[$decorationfontkey]['ut']) {
					$ut = $this->fonts[$decorationfontkey]['ut'] / 1000 * $decorationfontsize;
				} else {
					$ut = 60 / 1000 * $decorationfontsize;
				}
				if (isset($this->fonts[$decorationfontkey]['up']) && $this->fonts[$decorationfontkey]['up']) {
					$up = $this->fonts[$decorationfontkey]['up'];
				} else {
					$up = -100;
				}
				$adjusty = (-$up / 1000 * $decorationfontsize) + $ut / 2;
				$ubaseline = $glyphYorigin - $this->textparam['u-decoration']['baseline'] / $shrin_k;
				$olw = $this->LineWidth;
				$sub .=' ' . (sprintf(' %.3F w 0 j 0 J ', $ut * _MPDFK));
				$sub .=' ' . $this->_dounderline($this->x + $dx, $this->y + $ubaseline + $adjusty, $txt, $OTLdata, $textvar);
				$sub .=' ' . (sprintf(' %.3F w 2 j 2 J ', $olw * _MPDFK));
				if ($this->FillColor != $c) {
					$sub .= ' ' . $this->FillColor . ' ';
				}
			}

			// STRIKETHROUGH
			if ($textvar & FD_LINETHROUGH) { // mPDF 5.7.1	// mPDF 6
				// mPDF 5.7.3  inline text-decoration parameters
				$c = $this->textparam['s-decoration']['color'];
				if ($this->FillColor != $c) {
					$sub .= ' ' . $c . ' ';
				}
				// mPDF 5.7.3  inline text-decoration parameters
				$decorationfontkey = $this->textparam['s-decoration']['fontkey'];
				$decorationfontsize = $this->textparam['s-decoration']['fontsize'] / $shrin_k;
				// Use yStrikeoutSize from OS/2 if available
				if (isset($this->fonts[$decorationfontkey]['strs']) && $this->fonts[$decorationfontkey]['strs']) {
					$ut = $this->fonts[$decorationfontkey]['strs'] / 1000 * $decorationfontsize;
				}
				// else use underlineThickness from post if available
				elseif (isset($this->fonts[$decorationfontkey]['ut']) && $this->fonts[$decorationfontkey]['ut']) {
					$ut = $this->fonts[$decorationfontkey]['ut'] / 1000 * $decorationfontsize;
				} else {
					$ut = 50 / 1000 * $decorationfontsize;
				}
				// Use yStrikeoutPosition from OS/2 if available
				if (isset($this->fonts[$decorationfontkey]['strp']) && $this->fonts[$decorationfontkey]['strp']) {
					$up = $this->fonts[$decorationfontkey]['strp'];
					$adjusty = (-$up / 1000 * $decorationfontsize);
				}
				// else use a fraction ($this->baselineS) of CapHeight
				else {
					if (isset($this->fonts[$decorationfontkey]['desc']['CapHeight']) && $this->fonts[$decorationfontkey]['desc']['CapHeight']) {
						$ch = $this->fonts[$decorationfontkey]['desc']['CapHeight'];
					} else {
						$ch = 700;
					}
					$adjusty = (-$ch / 1000 * $decorationfontsize) * $this->baselineS;
				}

				$sbaseline = $glyphYorigin - $this->textparam['s-decoration']['baseline'] / $shrin_k;
				$olw = $this->LineWidth;
				$sub .=' ' . (sprintf(' %.3F w 0 j 0 J ', $ut * _MPDFK));
				$sub .=' ' . $this->_dounderline($this->x + $dx, $this->y + $sbaseline + $adjusty, $txt, $OTLdata, $textvar);
				$sub .=' ' . (sprintf(' %.3F w 2 j 2 J ', $olw * _MPDFK));
				if ($this->FillColor != $c) {
					$sub .= ' ' . $this->FillColor . ' ';
				}
			}

			// mPDF 5.7.3  inline text-decoration parameters
			// OVERLINE
			if ($textvar & FD_OVERLINE) { // mPDF 5.7.1	// mPDF 6
				// mPDF 5.7.3  inline text-decoration parameters
				$c = $this->textparam['o-decoration']['color'];
				if ($this->FillColor != $c) {
					$sub .= ' ' . $c . ' ';
				}
				// mPDF 5.7.3  inline text-decoration parameters
				$decorationfontkey = $this->textparam['o-decoration']['fontkey'] / $shrin_k;
				$decorationfontsize = $this->textparam['o-decoration']['fontsize'];
				if (isset($this->fonts[$decorationfontkey]['ut']) && $this->fonts[$decorationfontkey]['ut']) {
					$ut = $this->fonts[$decorationfontkey]['ut'] / 1000 * $decorationfontsize;
				} else {
					$ut = 60 / 1000 * $decorationfontsize;
				}
				if (isset($this->fonts[$decorationfontkey]['desc']['CapHeight']) && $this->fonts[$decorationfontkey]['desc']['CapHeight']) {
					$ch = $this->fonts[$decorationfontkey]['desc']['CapHeight'];
				} else {
					$ch = 700;
				}
				$adjusty = (-$ch / 1000 * $decorationfontsize) * $this->baselineO;
				$obaseline = $glyphYorigin - $this->textparam['o-decoration']['baseline'] / $shrin_k;
				$olw = $this->LineWidth;
				$sub .=' ' . (sprintf(' %.3F w 0 j 0 J ', $ut * _MPDFK));
				$sub .=' ' . $this->_dounderline($this->x + $dx, $this->y + $obaseline + $adjusty, $txt, $OTLdata, $textvar);
				$sub .=' ' . (sprintf(' %.3F w 2 j 2 J ', $olw * _MPDFK));
				if ($this->FillColor != $c) {
					$sub .= ' ' . $this->FillColor . ' ';
				}
			}

			// TEXT SHADOW
			if ($this->textshadow) {  // First to process is last in CSS comma separated shadows
				foreach ($this->textshadow AS $ts) {
					$s .= ' q ';
					$s .= $this->SetTColor($ts['col'], true) . "\n";
					if ($ts['col']{0} == 5 && ord($ts['col']{4}) < 100) { // RGBa
						$s .= $this->SetAlpha(ord($ts['col']{4}) / 100, 'Normal', true, 'F') . "\n";
					} elseif ($ts['col']{0} == 6 && ord($ts['col']{5}) < 100) { // CMYKa
						$s .= $this->SetAlpha(ord($ts['col']{5}) / 100, 'Normal', true, 'F') . "\n";
					} elseif ($ts['col']{0} == 1 && $ts['col']{2} == 1 && ord($ts['col']{3}) < 100) { // Gray
						$s .= $this->SetAlpha(ord($ts['col']{3}) / 100, 'Normal', true, 'F') . "\n";
					}
					$s .= sprintf(' 1 0 0 1 %.4F %.4F cm', $ts['x'] * _MPDFK, -$ts['y'] * _MPDFK) . "\n";
					$s .= $sub;
					$s .= ' Q ';
				}
			}

			$s .= $sub;

			// COLOR
			if ($this->ColorFlag)
				$s .=' Q';

			// LINK
			if ($link != '') {
				$this->Link($this->x, $boxtop, $w, $boxheight, $link);
			}
		}
		if ($s)
			$this->_out($s);

		// WORD SPACING
		if ($this->ws && !$this->usingCoreFont) {
			$this->_out(sprintf('BT %.3F Tc ET', $this->charspacing));
		}
		$this->lasth = $h;
		if (strpos($txt, "\n") !== false)
			$ln = 1; // cell recognizes \n from <BR> tag
		if ($ln > 0) {
			//Go to next line
			$this->y += $h;
			if ($ln == 1) {
				//Move to next line
				if ($currentx != 0) {
					$this->x = $currentx;
				} else {
					$this->x = $this->lMargin;
				}
			}
		} else
			$this->x+=$w;
	}

	function applyGPOSpdf($txt, $aix, $x, $y, $OTLdata, $textvar = 0)
	{
		// Generate PDF string
		//==============================
		if ((isset($this->CurrentFont['sip']) && $this->CurrentFont['sip']) || (isset($this->CurrentFont['smp']) && $this->CurrentFont['smp'])) {
			$sipset = true;
		} else {
			$sipset = false;
		}

		if ($textvar & FC_SMALLCAPS) {
			$smcaps = true;
		} // IF SmallCaps using transformation, NOT OTL
		else {
			$smcaps = false;
		}

		if ($sipset) {
			$fontid = $last_fontid = $original_fontid = $this->CurrentFont['subsetfontids'][0];
		} else {
			$fontid = $last_fontid = $original_fontid = $this->CurrentFont['i'];
		}
		$SmallCapsON = false;  // state: uppercase/not
		$lastSmallCapsON = false; // state: uppercase/not
		$last_fontsize = $fontsize = $this->FontSizePt;
		$last_fontstretch = $fontstretch = 100;
		$groupBreak = false;

		$unicode = $this->UTF8StringToArray($txt);

		$GPOSinfo = (isset($OTLdata['GPOSinfo']) ? $OTLdata['GPOSinfo'] : array());
		$charspacing = ($this->charspacing * 1000 / $this->FontSizePt);
		$wordspacing = ($this->ws * 1000 / $this->FontSizePt);

		$XshiftBefore = 0;
		$XshiftAfter = 0;
		$lastYPlacement = 0;

		if ($sipset) {
			// mPDF 6  DELETED ********
			//		$txt= preg_replace('/'.preg_quote($this->aliasNbPg,'/').'/', chr(7), $txt);	// ? Need to adjust OTL info
			//		$txt= preg_replace('/'.preg_quote($this->aliasNbPgGp,'/').'/', chr(8), $txt);	// ? Need to adjust OTL info
			$tj = '<';
		} else {
			$tj = '(';
		}

		for ($i = 0; $i < count($unicode); $i++) {
			$c = $unicode[$i];
			$tx = '';
			$XshiftBefore = $XshiftAfter;
			$XshiftAfter = 0;
			$YPlacement = 0;
			$groupBreak = false;
			$kashida = 0;
			if (!empty($OTLdata)) {
				// YPlacement from GPOS
				if (isset($GPOSinfo[$i]['YPlacement']) && $GPOSinfo[$i]['YPlacement']) {
					$YPlacement = $GPOSinfo[$i]['YPlacement'] * $this->FontSizePt / $this->CurrentFont['unitsPerEm'];
					$groupBreak = true;
				}
				// XPlacement from GPOS
				if (isset($GPOSinfo[$i]['XPlacement']) && $GPOSinfo[$i]['XPlacement']) {

					if (!isset($GPOSinfo[$i]['wDir']) || $GPOSinfo[$i]['wDir'] != 'RTL') {
						if (isset($GPOSinfo[$i]['BaseWidth'])) {
							$GPOSinfo[$i]['XPlacement'] -= $GPOSinfo[$i]['BaseWidth'];
						}
					}

					// Convert to PDF Text space (thousandths of a unit );
					$XshiftBefore += $GPOSinfo[$i]['XPlacement'] * 1000 / $this->CurrentFont['unitsPerEm'];
					$XshiftAfter += -$GPOSinfo[$i]['XPlacement'] * 1000 / $this->CurrentFont['unitsPerEm'];
				}

				// Kashida from GPOS
				// Kashida is set as an absolute length value, but to adjust text needs to be converted to
				// font-related size
				if (isset($GPOSinfo[$i]['kashida_space']) && $GPOSinfo[$i]['kashida_space']) {
					$kashida = $GPOSinfo[$i]['kashida_space'];
				}

				if ($c == 32) { // word spacing
					$XshiftAfter += $wordspacing;
				}

				if (substr($OTLdata['group'], ($i + 1), 1) != 'M') { // Don't add inter-character spacing before Marks
					$XshiftAfter += $charspacing;
				}

				// ...applyGPOSpdf...
				// XAdvance from GPOS - Convert to PDF Text space (thousandths of a unit );
				if (((isset($GPOSinfo[$i]['wDir']) && $GPOSinfo[$i]['wDir'] != 'RTL') || !isset($GPOSinfo[$i]['wDir'])) && isset($GPOSinfo[$i]['XAdvanceL']) && $GPOSinfo[$i]['XAdvanceL']) {
					$XshiftAfter += $GPOSinfo[$i]['XAdvanceL'] * 1000 / $this->CurrentFont['unitsPerEm'];
				} elseif (isset($GPOSinfo[$i]['wDir']) && $GPOSinfo[$i]['wDir'] == 'RTL' && isset($GPOSinfo[$i]['XAdvanceR']) && $GPOSinfo[$i]['XAdvanceR']) {
					$XshiftAfter += $GPOSinfo[$i]['XAdvanceR'] * 1000 / $this->CurrentFont['unitsPerEm'];
				}
			}
			// Character & Word spacing - if NOT OTL
			else {
				$XshiftAfter += $charspacing;
				if ($c == 32) {
					$XshiftAfter += $wordspacing;
				}
			}

			// IF Kerning done using pairs rather than OTL
			if ($textvar & FC_KERNING) {
				if ($i > 0 && isset($this->CurrentFont['kerninfo'][$unicode[($i - 1)]][$unicode[$i]])) {
					$XshiftBefore += $this->CurrentFont['kerninfo'][$unicode[($i - 1)]][$unicode[$i]];
				}
			}

			if ($YPlacement != $lastYPlacement) {
				$groupBreak = true;
			}

			if ($XshiftBefore) {  // +ve value in PDF moves to the left
				// If Fontstretch is ongoing, need to adjust X adjustments because these will be stretched out.
				$XshiftBefore *= 100 / $last_fontstretch;
				if ($sipset) {
					$tj .= sprintf('>%d<', (-$XshiftBefore));
				} else {
					$tj .= sprintf(')%d(', (-$XshiftBefore));
				}
			}

			// Small-Caps
			if ($smcaps) {
				if (isset($this->upperCase[$c])) {
					$c = $this->upperCase[$c];
					//$this->CurrentFont['subset'][$this->upperCase[$c]] = $this->upperCase[$c];	// add the CAP to subset
					$SmallCapsON = true;
					// For $sipset
					if (!$lastSmallCapsON) {   // Turn ON SmallCaps
						$groupBreak = true;
						$fontstretch = $this->smCapsStretch;
						$fontsize = $this->FontSizePt * $this->smCapsScale;
					}
				} else {
					$SmallCapsON = false;
					if ($lastSmallCapsON) {  // Turn OFF SmallCaps
						$groupBreak = true;
						$fontstretch = 100;
						$fontsize = $this->FontSizePt;
					}
				}
			}

			// Prepare Text and Select Font ID
			if ($sipset) {
				// mPDF 6  DELETED ********
				//if ($c == 7 || $c == 8) {
				//	if ($original_fontid != $last_fontid) {
				//		$groupBreak = true;
				//		$fontid = $original_fontid;
				//	}
				//	if ($c == 7) { $tj .= $this->aliasNbPgHex; }
				//	else { $tj .= $this->aliasNbPgGpHex; }
				//	continue;
				//}
				for ($j = 0; $j < 99; $j++) {
					$init = array_search($c, $this->CurrentFont['subsets'][$j]);
					if ($init !== false) {
						if ($this->CurrentFont['subsetfontids'][$j] != $last_fontid) {
							$groupBreak = true;
							$fontid = $this->CurrentFont['subsetfontids'][$j];
						}
						$tx = sprintf("%02s", strtoupper(dechex($init)));
						break;
					} elseif (count($this->CurrentFont['subsets'][$j]) < 255) {
						$n = count($this->CurrentFont['subsets'][$j]);
						$this->CurrentFont['subsets'][$j][$n] = $c;
						if ($this->CurrentFont['subsetfontids'][$j] != $last_fontid) {
							$groupBreak = true;
							$fontid = $this->CurrentFont['subsetfontids'][$j];
						}
						$tx = sprintf("%02s", strtoupper(dechex($n)));
						break;
					} elseif (!isset($this->CurrentFont['subsets'][($j + 1)])) {
						$this->CurrentFont['subsets'][($j + 1)] = array(0 => 0);
						$this->CurrentFont['subsetfontids'][($j + 1)] = count($this->fonts) + $this->extraFontSubsets + 1;
						$this->extraFontSubsets++;
					}
				}
			} else {
				$tx = code2utf($c);
				if ($this->usingCoreFont) {
					$tx = utf8_decode($tx);
				} else {
					$tx = $this->UTF8ToUTF16BE($tx, false);
				}
				$tx = $this->_escape($tx);
			}

			// If any settings require a new Text Group
			if ($groupBreak || $fontstretch != $last_fontstretch) {
				if ($sipset) {
					$tj .= '>] TJ ';
				} else {
					$tj .= ')] TJ ';
				}
				if ($fontid != $last_fontid || $fontsize != $last_fontsize) {
					$tj .= sprintf(' /F%d %.3F Tf ', $fontid, $fontsize);
				}
				if ($fontstretch != $last_fontstretch) {
					$tj .= sprintf('%d Tz ', $fontstretch);
				}
				if ($YPlacement != $lastYPlacement) {
					$tj .= sprintf('%.3F Ts ', $YPlacement);
				}
				if ($sipset) {
					$tj .= '[<';
				} else {
					$tj .= '[(';
				}
			}

			// Output the code for the txt character
			$tj .= $tx;
			$lastSmallCapsON = $SmallCapsON;
			$last_fontid = $fontid;
			$last_fontsize = $fontsize;
			$last_fontstretch = $fontstretch;

			// Kashida
			if ($kashida) {
				$c = 0x0640; // add the Tatweel U+0640
				if (isset($this->CurrentFont['subset'])) {
					$this->CurrentFont['subset'][$c] = $c;
				}
				$kashida *= 1000 / $this->FontSizePt;
				$tatw = $this->_getCharWidth($this->CurrentFont['cw'], 0x0640);

				// Get YPlacement from next Base character
				$nextbase = $i + 1;
				while ($OTLdata['group']{$nextbase} != 'C') {
					$nextbase++;
				}
				if (isset($GPOSinfo[$nextbase]) && isset($GPOSinfo[$nextbase]['YPlacement']) && $GPOSinfo[$nextbase]['YPlacement']) {
					$YPlacement = $GPOSinfo[$nextbase]['YPlacement'] * $this->FontSizePt / $this->CurrentFont['unitsPerEm'];
				}

				// Prepare Text and Select Font ID
				if ($sipset) {
					for ($j = 0; $j < 99; $j++) {
						$init = array_search($c, $this->CurrentFont['subsets'][$j]);
						if ($init !== false) {
							if ($this->CurrentFont['subsetfontids'][$j] != $last_fontid) {
								$fontid = $this->CurrentFont['subsetfontids'][$j];
							}
							$tx = sprintf("%02s", strtoupper(dechex($init)));
							break;
						} elseif (count($this->CurrentFont['subsets'][$j]) < 255) {
							$n = count($this->CurrentFont['subsets'][$j]);
							$this->CurrentFont['subsets'][$j][$n] = $c;
							if ($this->CurrentFont['subsetfontids'][$j] != $last_fontid) {
								$fontid = $this->CurrentFont['subsetfontids'][$j];
							}
							$tx = sprintf("%02s", strtoupper(dechex($n)));
							break;
						} elseif (!isset($this->CurrentFont['subsets'][($j + 1)])) {
							$this->CurrentFont['subsets'][($j + 1)] = array(0 => 0);
							$this->CurrentFont['subsetfontids'][($j + 1)] = count($this->fonts) + $this->extraFontSubsets + 1;
							$this->extraFontSubsets++;
						}
					}
				} else {
					$tx = code2utf($c);
					$tx = $this->UTF8ToUTF16BE($tx, false);
					$tx = $this->_escape($tx);
				}

				if ($kashida > $tatw) {
					// Insert multiple tatweel characters, repositioning the last one to give correct total length
					$fontstretch = 100;
					$nt = intval($kashida / $tatw);
					$nudgeback = (($nt + 1) * $tatw) - $kashida;
					$optx = str_repeat($tx, $nt);
					if ($sipset) {
						$optx .= sprintf('>%d<', ($nudgeback));
					} else {
						$optx .= sprintf(')%d(', ($nudgeback));
					}
					$optx .= $tx; // #last
				} else {
					// Insert single tatweel character and use fontstretch to get correct length
					$fontstretch = ($kashida / $tatw) * 100;
					$optx = $tx;
				}

				if ($sipset) {
					$tj .= '>] TJ ';
				} else {
					$tj .= ')] TJ ';
				}
				if ($fontid != $last_fontid || $fontsize != $last_fontsize) {
					$tj .= sprintf(' /F%d %.3F Tf ', $fontid, $fontsize);
				}
				if ($fontstretch != $last_fontstretch) {
					$tj .= sprintf('%d Tz ', $fontstretch);
				}
				$tj .= sprintf('%.3F Ts ', $YPlacement);
				if ($sipset) {
					$tj .= '[<';
				} else {
					$tj .= '[(';
				}

				// Output the code for the txt character(s)
				$tj .= $optx;
				$last_fontid = $fontid;
				$last_fontstretch = $fontstretch;
				$fontstretch = 100;
			}

			$lastYPlacement = $YPlacement;
		}


		// Finish up
		if ($sipset) {
			$tj .= '>';
			if ($XshiftAfter) {
				$tj .= sprintf('%d', (-$XshiftAfter));
			}
			if ($last_fontid != $original_fontid) {
				$tj .= '] TJ ';
				$tj .= sprintf(' /F%d %.3F Tf ', $original_fontid, $fontsize);
				$tj .= '[';
			}
			$tj = preg_replace('/([^\\\])<>/', '\\1 ', $tj);
		} else {
			$tj .= ')';
			if ($XshiftAfter) {
				$tj .= sprintf('%d', (-$XshiftAfter));
			}
			if ($last_fontid != $original_fontid) {
				$tj .= '] TJ ';
				$tj .= sprintf(' /F%d %.3F Tf ', $original_fontid, $fontsize);
				$tj .= '[';
			}
			$tj = preg_replace('/([^\\\])\(\)/', '\\1 ', $tj);
		}


		$s = sprintf(' BT ' . $aix . ' 0 Tc 0 Tw [%s] TJ ET ', $x, $y, $tj);

		//echo $s."\n\n"; // exit;

		return $s;
	}

	function _kern($txt, $mode, $aix, $x, $y)
	{
		if ($mode == 'MBTw') { // Multibyte requiring word spacing
			$space = ' ';
			//Convert string to UTF-16BE without BOM
			$space = $this->UTF8ToUTF16BE($space, false);
			$space = $this->_escape($space);
			$s = sprintf(' BT ' . $aix, $x * _MPDFK, ($this->h - $y) * _MPDFK);
			$t = explode(' ', $txt);
			for ($i = 0; $i < count($t); $i++) {
				$tx = $t[$i];

				$tj = '(';
				$unicode = $this->UTF8StringToArray($tx);
				for ($ti = 0; $ti < count($unicode); $ti++) {
					if ($ti > 0 && isset($this->CurrentFont['kerninfo'][$unicode[($ti - 1)]][$unicode[$ti]])) {
						$kern = -$this->CurrentFont['kerninfo'][$unicode[($ti - 1)]][$unicode[$ti]];
						$tj .= sprintf(')%d(', $kern);
					}
					$tc = code2utf($unicode[$ti]);
					$tc = $this->UTF8ToUTF16BE($tc, false);
					$tj .= $this->_escape($tc);
				}
				$tj .= ')';
				$s.=sprintf(' %.3F Tc [%s] TJ', $this->charspacing, $tj);


				if (($i + 1) < count($t)) {
					$s.=sprintf(' %.3F Tc (%s) Tj', $this->ws + $this->charspacing, $space);
				}
			}
			$s.=' ET ';
		} elseif (!$this->usingCoreFont) {
			$s = '';
			$tj = '(';
			$unicode = $this->UTF8StringToArray($txt);
			for ($i = 0; $i < count($unicode); $i++) {
				if ($i > 0 && isset($this->CurrentFont['kerninfo'][$unicode[($i - 1)]][$unicode[$i]])) {
					$kern = -$this->CurrentFont['kerninfo'][$unicode[($i - 1)]][$unicode[$i]];
					$tj .= sprintf(')%d(', $kern);
				}
				$tx = code2utf($unicode[$i]);
				$tx = $this->UTF8ToUTF16BE($tx, false);
				$tj .= $this->_escape($tx);
			}
			$tj .= ')';
			$s.=sprintf(' BT ' . $aix . ' [%s] TJ ET ', $x * _MPDFK, ($this->h - $y) * _MPDFK, $tj);
		} else { // CORE Font
			$s = '';
			$tj = '(';
			$l = strlen($txt);
			for ($i = 0; $i < $l; $i++) {
				if ($i > 0 && isset($this->CurrentFont['kerninfo'][$txt[($i - 1)]][$txt[$i]])) {
					$kern = -$this->CurrentFont['kerninfo'][$txt[($i - 1)]][$txt[$i]];
					$tj .= sprintf(')%d(', $kern);
				}
				$tj .= $this->_escape($txt[$i]);
			}
			$tj .= ')';
			$s.=sprintf(' BT ' . $aix . ' [%s] TJ ET ', $x * _MPDFK, ($this->h - $y) * _MPDFK, $tj);
		}

		return $s;
	}

	function MultiCell($w, $h, $txt, $border = 0, $align = '', $fill = 0, $link = '', $directionality = 'ltr', $encoded = false, $OTLdata = false, $maxrows = false)
	{
		// maxrows is called from mpdfform->TEXTAREA
		// Parameter (pre-)encoded - When called internally from form::textarea - mb_encoding already done and OTL - but not reverse RTL
		if (!$encoded) {
			$txt = $this->purify_utf8_text($txt);
			if ($this->text_input_as_HTML) {
				$txt = $this->all_entities_to_utf8($txt);
			}
			if ($this->usingCoreFont) {
				$txt = mb_convert_encoding($txt, $this->mb_enc, 'UTF-8');
			}
			if (preg_match("/([" . $this->pregRTLchars . "])/u", $txt)) {
				$this->biDirectional = true;
			} // *OTL*
			/* -- OTL -- */
			$OTLdata = array();
			// Use OTL OpenType Table Layout - GSUB & GPOS
			if (isset($this->CurrentFont['useOTL']) && $this->CurrentFont['useOTL']) {
				$txt = $this->otl->applyOTL($txt, $this->CurrentFont['useOTL']);
				$OTLdata = $this->otl->OTLdata;
			}
			if ($directionality == 'rtl' || $this->biDirectional) {
				if (!isset($OTLdata)) {
					$unicode = $this->UTF8StringToArray($txt, false);
					$is_strong = false;
					$this->getBasicOTLdata($OTLdata, $unicode, $is_strong);
				}
			}
			/* -- END OTL -- */
		}
		if (!$align) {
			$align = $this->defaultAlign;
		}

		//Output text with automatic or explicit line breaks
		$cw = &$this->CurrentFont['cw'];
		if ($w == 0)
			$w = $this->w - $this->rMargin - $this->x;

		$wmax = ($w - ($this->cMarginL + $this->cMarginR));
		if ($this->usingCoreFont) {
			$s = str_replace("\r", '', $txt);
			$nb = strlen($s);
			while ($nb > 0 and $s[$nb - 1] == "\n")
				$nb--;
		} else {
			$s = str_replace("\r", '', $txt);
			$nb = mb_strlen($s, $this->mb_enc);
			while ($nb > 0 and mb_substr($s, $nb - 1, 1, $this->mb_enc) == "\n")
				$nb--;
		}
		$b = 0;
		if ($border) {
			if ($border == 1) {
				$border = 'LTRB';
				$b = 'LRT';
				$b2 = 'LR';
			} else {
				$b2 = '';
				if (is_int(strpos($border, 'L')))
					$b2.='L';
				if (is_int(strpos($border, 'R')))
					$b2.='R';
				$b = is_int(strpos($border, 'T')) ? $b2 . 'T' : $b2;
			}
		}
		$sep = -1;
		$i = 0;
		$j = 0;
		$l = 0;
		$ns = 0;
		$nl = 1;

		$rows = 0;
		$start_y = $this->y;

		if (!$this->usingCoreFont) {
			$inclCursive = false;
			if (preg_match("/([" . $this->pregCURSchars . "])/u", $s)) {
				$inclCursive = true;
			}
			while ($i < $nb) {
				//Get next character
				$c = mb_substr($s, $i, 1, $this->mb_enc);
				if ($c == "\n") {
					//Explicit line break
					// WORD SPACING
					$this->ResetSpacing();
					$tmp = rtrim(mb_substr($s, $j, $i - $j, $this->mb_enc));
					$tmpOTLdata = false;
					/* -- OTL -- */
					if (isset($OTLdata)) {
						$tmpOTLdata = $this->otl->sliceOTLdata($OTLdata, $j, $i - $j);
						$this->otl->trimOTLdata($tmpOTLdata, false, true);
						$this->magic_reverse_dir($tmp, $directionality, $tmpOTLdata);
					}
					/* -- END OTL -- */
					$this->Cell($w, $h, $tmp, $b, 2, $align, $fill, $link, 0, 0, 0, 'M', 0, false, $tmpOTLdata);
					if ($maxrows != false && isset($this->mpdfform) && ($this->y - $start_y) / $h > $maxrows) {
						return false;
					}
					$i++;
					$sep = -1;
					$j = $i;
					$l = 0;
					$ns = 0;
					$nl++;
					if ($border and $nl == 2)
						$b = $b2;
					continue;
				}
				if ($c == " ") {
					$sep = $i;
					$ls = $l;
					$ns++;
				}

				$l += $this->GetCharWidthNonCore($c);

				if ($l > $wmax) {
					//Automatic line break
					if ($sep == -1) { // Only one word
						if ($i == $j)
							$i++;
						// WORD SPACING
						$this->ResetSpacing();
						$tmp = rtrim(mb_substr($s, $j, $i - $j, $this->mb_enc));
						$tmpOTLdata = false;
						/* -- OTL -- */
						if (isset($OTLdata)) {
							$tmpOTLdata = $this->otl->sliceOTLdata($OTLdata, $j, $i - $j);
							$this->otl->trimOTLdata($tmpOTLdata, false, true);
							$this->magic_reverse_dir($tmp, $directionality, $tmpOTLdata);
						}
						/* -- END OTL -- */
						$this->Cell($w, $h, $tmp, $b, 2, $align, $fill, $link, 0, 0, 0, 'M', 0, false, $tmpOTLdata);
					} else {
						$tmp = rtrim(mb_substr($s, $j, $sep - $j, $this->mb_enc));
						$tmpOTLdata = false;
						/* -- OTL -- */
						if (isset($OTLdata)) {
							$tmpOTLdata = $this->otl->sliceOTLdata($OTLdata, $j, $sep - $j);
							$this->otl->trimOTLdata($tmpOTLdata, false, true);
						}
						/* -- END OTL -- */
						if ($align == 'J') {
							//////////////////////////////////////////
							// JUSTIFY J using Unicode fonts (Word spacing doesn't work)
							// WORD SPACING UNICODE
							// Change NON_BREAKING SPACE to spaces so they are 'spaced' properly
							$tmp = str_replace(chr(194) . chr(160), chr(32), $tmp);
							$len_ligne = $this->GetStringWidth($tmp, false, $tmpOTLdata);
							$nb_carac = mb_strlen($tmp, $this->mb_enc);
							$nb_spaces = mb_substr_count($tmp, ' ', $this->mb_enc);
							// Take off number of Marks
							// Use GPOS OTL
							if (isset($this->CurrentFont['useOTL']) && ($this->CurrentFont['useOTL'])) {
								if (isset($tmpOTLdata['group']) && $tmpOTLdata['group']) {
									$nb_carac -= substr_count($tmpOTLdata['group'], 'M');
								}
							}

							list($charspacing, $ws, $kashida) = $this->GetJspacing($nb_carac, $nb_spaces, ((($wmax) - $len_ligne) * _MPDFK), $inclCursive, $tmpOTLdata);
							$this->SetSpacing($charspacing, $ws);
							//////////////////////////////////////////
						}
						if (isset($OTLdata)) {
							$this->magic_reverse_dir($tmp, $directionality, $tmpOTLdata);
						}
						$this->Cell($w, $h, $tmp, $b, 2, $align, $fill, $link, 0, 0, 0, 'M', 0, false, $tmpOTLdata);
						$i = $sep + 1;
					}
					if ($maxrows != false && isset($this->mpdfform) && ($this->y - $start_y) / $h > $maxrows) {
						return false;
					}
					$sep = -1;
					$j = $i;
					$l = 0;
					$ns = 0;
					$nl++;
					if ($border and $nl == 2)
						$b = $b2;
				} else
					$i++;
			}
			//Last chunk
			// WORD SPACING

			$this->ResetSpacing();
		}


		else {

			while ($i < $nb) {
				//Get next character
				$c = $s[$i];
				if ($c == "\n") {
					//Explicit line break
					// WORD SPACING
					$this->ResetSpacing();
					$this->Cell($w, $h, substr($s, $j, $i - $j), $b, 2, $align, $fill, $link);
					if ($maxrows != false && isset($this->mpdfform) && ($this->y - $start_y) / $h > $maxrows) {
						return false;
					}
					$i++;
					$sep = -1;
					$j = $i;
					$l = 0;
					$ns = 0;
					$nl++;
					if ($border and $nl == 2)
						$b = $b2;
					continue;
				}
				if ($c == " ") {
					$sep = $i;
					$ls = $l;
					$ns++;
				}

				$l += $this->GetCharWidthCore($c);
				if ($l > $wmax) {
					//Automatic line break
					if ($sep == -1) {
						if ($i == $j)
							$i++;
						// WORD SPACING
						$this->ResetSpacing();
						$this->Cell($w, $h, substr($s, $j, $i - $j), $b, 2, $align, $fill, $link);
					}
					else {
						if ($align == 'J') {
							$tmp = rtrim(substr($s, $j, $sep - $j));
							//////////////////////////////////////////
							// JUSTIFY J using Unicode fonts (Word spacing doesn't work)
							// WORD SPACING NON_UNICODE/CJK
							// Change NON_BREAKING SPACE to spaces so they are 'spaced' properly
							$tmp = str_replace(chr(160), chr(32), $tmp);
							$len_ligne = $this->GetStringWidth($tmp);
							$nb_carac = strlen($tmp);
							$nb_spaces = substr_count($tmp, ' ');
							$tmpOTLdata = array();
							list($charspacing, $ws, $kashida) = $this->GetJspacing($nb_carac, $nb_spaces, ((($wmax) - $len_ligne) * _MPDFK), false, $tmpOTLdata);
							$this->SetSpacing($charspacing, $ws);
							//////////////////////////////////////////
						}
						$this->Cell($w, $h, substr($s, $j, $sep - $j), $b, 2, $align, $fill, $link);
						$i = $sep + 1;
					}
					if ($maxrows != false && isset($this->mpdfform) && ($this->y - $start_y) / $h > $maxrows) {
						return false;
					}
					$sep = -1;
					$j = $i;
					$l = 0;
					$ns = 0;
					$nl++;
					if ($border and $nl == 2)
						$b = $b2;
				} else
					$i++;
			}
			//Last chunk
			// WORD SPACING

			$this->ResetSpacing();
		}
		//Last chunk
		if ($border and is_int(strpos($border, 'B')))
			$b.='B';
		if (!$this->usingCoreFont) {
			$tmp = rtrim(mb_substr($s, $j, $i - $j, $this->mb_enc));
			$tmpOTLdata = false;
			/* -- OTL -- */
			if (isset($OTLdata)) {
				$tmpOTLdata = $this->otl->sliceOTLdata($OTLdata, $j, $i - $j);
				$this->otl->trimOTLdata($tmpOTLdata, false, true);
				$this->magic_reverse_dir($tmp, $directionality, $tmpOTLdata);
			}
			/* -- END OTL -- */
			$this->Cell($w, $h, $tmp, $b, 2, $align, $fill, $link, 0, 0, 0, 'M', 0, false, $tmpOTLdata);
		} else {
			$this->Cell($w, $h, substr($s, $j, $i - $j), $b, 2, $align, $fill, $link);
		}
		$this->x = $this->lMargin;
	}

	/* -- DIRECTW -- */

	function Write($h, $txt, $currentx = 0, $link = '', $directionality = 'ltr', $align = '')
	{
		if (!class_exists('directw', false)) {
			include(_MPDF_PATH . 'classes/directw.php');
		}
		if (empty($this->directw)) {
			$this->directw = new directw($this);
		}
		$this->directw->Write($h, $txt, $currentx, $link, $directionality, $align);
	}

	/* -- END DIRECTW -- */


	/* -- HTML-CSS -- */

	function saveInlineProperties()
	{
		$saved = array();
		$saved['family'] = $this->FontFamily;
		$saved['style'] = $this->FontStyle;
		$saved['sizePt'] = $this->FontSizePt;
		$saved['size'] = $this->FontSize;
		$saved['HREF'] = $this->HREF;
		$saved['textvar'] = $this->textvar; // mPDF 5.7.1
		$saved['OTLtags'] = $this->OTLtags; // mPDF 5.7.1
		$saved['textshadow'] = $this->textshadow;
		$saved['linewidth'] = $this->LineWidth;
		$saved['drawcolor'] = $this->DrawColor;
		$saved['textparam'] = $this->textparam;
		$saved['lSpacingCSS'] = $this->lSpacingCSS;
		$saved['wSpacingCSS'] = $this->wSpacingCSS;
		$saved['I'] = $this->I;
		$saved['B'] = $this->B;
		$saved['colorarray'] = $this->colorarray;
		$saved['bgcolorarray'] = $this->spanbgcolorarray;
		$saved['border'] = $this->spanborddet;
		$saved['color'] = $this->TextColor;
		$saved['bgcolor'] = $this->FillColor;
		$saved['lang'] = $this->currentLang;
		$saved['fontLanguageOverride'] = $this->fontLanguageOverride; // mPDF 5.7.1
		$saved['display_off'] = $this->inlineDisplayOff;

		return $saved;
	}

	function restoreInlineProperties(&$saved)
	{
		$FontFamily = $saved['family'];
		$this->FontStyle = $saved['style'];
		$this->FontSizePt = $saved['sizePt'];
		$this->FontSize = $saved['size'];

		$this->currentLang = $saved['lang'];
		$this->fontLanguageOverride = $saved['fontLanguageOverride']; // mPDF 5.7.1

		$this->ColorFlag = ($this->FillColor != $this->TextColor); //Restore ColorFlag as well

		$this->HREF = $saved['HREF'];
		$this->textvar = $saved['textvar']; // mPDF 5.7.1
		$this->OTLtags = $saved['OTLtags']; // mPDF 5.7.1
		$this->textshadow = $saved['textshadow'];
		$this->LineWidth = $saved['linewidth'];
		$this->DrawColor = $saved['drawcolor'];
		$this->textparam = $saved['textparam'];
		$this->inlineDisplayOff = $saved['display_off'];

		$this->lSpacingCSS = $saved['lSpacingCSS'];
		if (($this->lSpacingCSS || $this->lSpacingCSS === '0') && strtoupper($this->lSpacingCSS) != 'NORMAL') {
			$this->fixedlSpacing = $this->ConvertSize($this->lSpacingCSS, $this->FontSize);
		} else {
			$this->fixedlSpacing = false;
		}
		$this->wSpacingCSS = $saved['wSpacingCSS'];
		if ($this->wSpacingCSS && strtoupper($this->wSpacingCSS) != 'NORMAL') {
			$this->minwSpacing = $this->ConvertSize($this->wSpacingCSS, $this->FontSize);
		} else {
			$this->minwSpacing = 0;
		}

		$this->SetFont($FontFamily, $saved['style'], $saved['sizePt'], false);

		$this->currentfontstyle = $saved['style'];
		$this->currentfontsize = $saved['sizePt'];
		$this->SetStylesArray(array('B' => $saved['B'], 'I' => $saved['I'])); // mPDF 5.7.1

		$this->TextColor = $saved['color'];
		$this->FillColor = $saved['bgcolor'];
		$this->colorarray = $saved['colorarray'];
		$cor = $saved['colorarray'];
		if ($cor)
			$this->SetTColor($cor);
		$this->spanbgcolorarray = $saved['bgcolorarray'];
		$cor = $saved['bgcolorarray'];
		if ($cor)
			$this->SetFColor($cor);
		$this->spanborddet = $saved['border'];
	}

	// Used when ColActive for tables - updated to return first block with background fill OR borders
	function GetFirstBlockFill()
	{
		// Returns the first blocklevel that uses a bgcolor fill
		$startfill = 0;
		for ($i = 1; $i <= $this->blklvl; $i++) {
			if ($this->blk[$i]['bgcolor'] || $this->blk[$i]['border_left']['w'] || $this->blk[$i]['border_right']['w'] || $this->blk[$i]['border_top']['w'] || $this->blk[$i]['border_bottom']['w']) {
				$startfill = $i;
				break;
			}
		}
		return $startfill;
	}

	//-------------------------FLOWING BLOCK------------------------------------//
	//The following functions were originally written by Damon Kohler           //
	//--------------------------------------------------------------------------//

	function saveFont()
	{
		$saved = array();
		$saved['family'] = $this->FontFamily;
		$saved['style'] = $this->FontStyle;
		$saved['sizePt'] = $this->FontSizePt;
		$saved['size'] = $this->FontSize;
		$saved['curr'] = &$this->CurrentFont;
		$saved['lang'] = $this->currentLang; // mPDF 6
		$saved['color'] = $this->TextColor;
		$saved['spanbgcolor'] = $this->spanbgcolor;
		$saved['spanbgcolorarray'] = $this->spanbgcolorarray;
		$saved['bord'] = $this->spanborder;
		$saved['border'] = $this->spanborddet;
		$saved['HREF'] = $this->HREF;
		$saved['textvar'] = $this->textvar; // mPDF 5.7.1
		$saved['textshadow'] = $this->textshadow;
		$saved['linewidth'] = $this->LineWidth;
		$saved['drawcolor'] = $this->DrawColor;
		$saved['textparam'] = $this->textparam;
		$saved['ReqFontStyle'] = $this->ReqFontStyle;
		$saved['fixedlSpacing'] = $this->fixedlSpacing;
		$saved['minwSpacing'] = $this->minwSpacing;
		return $saved;
	}

	function restoreFont(&$saved, $write = true)
	{
		if (!isset($saved) || empty($saved))
			return;

		$this->FontFamily = $saved['family'];
		$this->FontStyle = $saved['style'];
		$this->FontSizePt = $saved['sizePt'];
		$this->FontSize = $saved['size'];
		$this->CurrentFont = &$saved['curr'];
		$this->currentLang = $saved['lang']; // mPDF 6
		$this->TextColor = $saved['color'];
		$this->spanbgcolor = $saved['spanbgcolor'];
		$this->spanbgcolorarray = $saved['spanbgcolorarray'];
		$this->spanborder = $saved['bord'];
		$this->spanborddet = $saved['border'];
		$this->ColorFlag = ($this->FillColor != $this->TextColor); //Restore ColorFlag as well
		$this->HREF = $saved['HREF'];
		$this->fixedlSpacing = $saved['fixedlSpacing'];
		$this->minwSpacing = $saved['minwSpacing'];
		$this->textvar = $saved['textvar'];  // mPDF 5.7.1
		$this->textshadow = $saved['textshadow'];
		$this->LineWidth = $saved['linewidth'];
		$this->DrawColor = $saved['drawcolor'];
		$this->textparam = $saved['textparam'];
		if ($write) {
			$this->SetFont($saved['family'], $saved['style'], $saved['sizePt'], true, true); // force output
			$fontout = (sprintf('BT /F%d %.3F Tf ET', $this->CurrentFont['i'], $this->FontSizePt));
			if ($this->page > 0 && ((isset($this->pageoutput[$this->page]['Font']) && $this->pageoutput[$this->page]['Font'] != $fontout) || !isset($this->pageoutput[$this->page]['Font']))) {
				$this->_out($fontout);
			}
			$this->pageoutput[$this->page]['Font'] = $fontout;
		} else
			$this->SetFont($saved['family'], $saved['style'], $saved['sizePt'], false);
		$this->ReqFontStyle = $saved['ReqFontStyle'];
	}

	function newFlowingBlock($w, $h, $a = '', $is_table = false, $blockstate = 0, $newblock = true, $blockdir = 'ltr', $table_draft = false)
	{
		if (!$a) {
			if ($blockdir == 'rtl') {
				$a = 'R';
			} else {
				$a = 'L';
			}
		}
		$this->flowingBlockAttr['width'] = ($w * _MPDFK);
		// line height in user units
		$this->flowingBlockAttr['is_table'] = $is_table;
		$this->flowingBlockAttr['table_draft'] = $table_draft;
		$this->flowingBlockAttr['height'] = $h;
		$this->flowingBlockAttr['lineCount'] = 0;
		$this->flowingBlockAttr['align'] = $a;
		$this->flowingBlockAttr['font'] = array();
		$this->flowingBlockAttr['content'] = array();
		$this->flowingBlockAttr['contentB'] = array();
		$this->flowingBlockAttr['contentWidth'] = 0;
		$this->flowingBlockAttr['blockstate'] = $blockstate;

		$this->flowingBlockAttr['newblock'] = $newblock;
		$this->flowingBlockAttr['valign'] = 'M';
		$this->flowingBlockAttr['blockdir'] = $blockdir;
		$this->flowingBlockAttr['cOTLdata'] = array(); // mPDF 5.7.1
		$this->flowingBlockAttr['lastBidiText'] = ''; // mPDF 5.7.1
		if (!empty($this->otl)) {
			$this->otl->lastBidiStrongType = '';
		} // *OTL*
	}

	function finishFlowingBlock($endofblock = false, $next = '')
	{
		$currentx = $this->x;
		//prints out the last chunk
		$is_table = $this->flowingBlockAttr['is_table'];
		$table_draft = $this->flowingBlockAttr['table_draft'];
		$maxWidth = & $this->flowingBlockAttr['width'];
		$stackHeight = & $this->flowingBlockAttr['height'];
		$align = & $this->flowingBlockAttr['align'];
		$content = & $this->flowingBlockAttr['content'];
		$contentB = & $this->flowingBlockAttr['contentB'];
		$font = & $this->flowingBlockAttr['font'];
		$contentWidth = & $this->flowingBlockAttr['contentWidth'];
		$lineCount = & $this->flowingBlockAttr['lineCount'];
		$valign = & $this->flowingBlockAttr['valign'];
		$blockstate = $this->flowingBlockAttr['blockstate'];

		$cOTLdata = & $this->flowingBlockAttr['cOTLdata']; // mPDF 5.7.1
		$newblock = $this->flowingBlockAttr['newblock'];
		$blockdir = $this->flowingBlockAttr['blockdir'];

		// *********** BLOCK BACKGROUND COLOR *****************//
		if ($this->blk[$this->blklvl]['bgcolor'] && !$is_table) {
			$fill = 0;
		} else {
			$this->SetFColor($this->ConvertColor(255));
			$fill = 0;
		}

		$hanger = '';
		// Always right trim!
		// Right trim last content and adjust width if needed to justify (later)
		if (isset($content[count($content) - 1]) && preg_match('/[ ]+$/', $content[count($content) - 1], $m)) {
			$strip = strlen($m[0]);
			$content[count($content) - 1] = substr($content[count($content) - 1], 0, (strlen($content[count($content) - 1]) - $strip));
			/* -- OTL -- */
			if (isset($this->CurrentFont['useOTL']) && $this->CurrentFont['useOTL']) {
				$this->otl->trimOTLdata($cOTLdata[count($cOTLdata) - 1], false, true);
			}
			/* -- END OTL -- */
		}

		// the amount of space taken up so far in user units
		$usedWidth = 0;

		// COLS
		$oldcolumn = $this->CurrCol;

		if ($this->ColActive && !$is_table) {
			$this->breakpoints[$this->CurrCol][] = $this->y;
		} // *COLUMNS*
		// Print out each chunk

		/* -- TABLES -- */
		if ($is_table) {
			$ipaddingL = 0;
			$ipaddingR = 0;
			$paddingL = 0;
			$paddingR = 0;
		} else {
			/* -- END TABLES -- */
			$ipaddingL = $this->blk[$this->blklvl]['padding_left'];
			$ipaddingR = $this->blk[$this->blklvl]['padding_right'];
			$paddingL = ($ipaddingL * _MPDFK);
			$paddingR = ($ipaddingR * _MPDFK);
			$this->cMarginL = $this->blk[$this->blklvl]['border_left']['w'];
			$this->cMarginR = $this->blk[$this->blklvl]['border_right']['w'];

			// Added mPDF 3.0 Float DIV
			$fpaddingR = 0;
			$fpaddingL = 0;
			/* -- CSS-FLOAT -- */
			if (count($this->floatDivs)) {
				list($l_exists, $r_exists, $l_max, $r_max, $l_width, $r_width) = $this->GetFloatDivInfo($this->blklvl);
				if ($r_exists) {
					$fpaddingR = $r_width;
				}
				if ($l_exists) {
					$fpaddingL = $l_width;
				}
			}
			/* -- END CSS-FLOAT -- */

			$usey = $this->y + 0.002;
			if (($newblock) && ($blockstate == 1 || $blockstate == 3) && ($lineCount == 0)) {
				$usey += $this->blk[$this->blklvl]['margin_top'] + $this->blk[$this->blklvl]['padding_top'] + $this->blk[$this->blklvl]['border_top']['w'];
			}
			/* -- CSS-IMAGE-FLOAT -- */
			// If float exists at this level
			if (isset($this->floatmargins['R']) && $usey <= $this->floatmargins['R']['y1'] && $usey >= $this->floatmargins['R']['y0'] && !$this->floatmargins['R']['skipline']) {
				$fpaddingR += $this->floatmargins['R']['w'];
			}
			if (isset($this->floatmargins['L']) && $usey <= $this->floatmargins['L']['y1'] && $usey >= $this->floatmargins['L']['y0'] && !$this->floatmargins['L']['skipline']) {
				$fpaddingL += $this->floatmargins['L']['w'];
			}
			/* -- END CSS-IMAGE-FLOAT -- */
		} // *TABLES*


		$lineBox = array();

		$this->_setInlineBlockHeights($lineBox, $stackHeight, $content, $font, $is_table);

		if ($is_table && count($content) == 0) {
			$stackHeight = 0;
		}

		if ($table_draft) {
			$this->y += $stackHeight;
			$this->objectbuffer = array();
			return 0;
		}

		// While we're at it, check if contains cursive text
		// Change NBSP to SPACE.
		// Re-calculate contentWidth
		$contentWidth = 0;

		foreach ($content as $k => $chunk) {
			$this->restoreFont($font[$k], false);
			if (!isset($this->objectbuffer[$k]) || (isset($this->objectbuffer[$k]) && !$this->objectbuffer[$k])) {
				// Soft Hyphens chr(173)
				if (!$this->usingCoreFont) {
					/* -- OTL -- */
					// mPDF 5.7.1
					if (isset($this->CurrentFont['useOTL']) && $this->CurrentFont['useOTL']) {
						$this->otl->removeChar($chunk, $cOTLdata[$k], "\xc2\xad");
						$this->otl->replaceSpace($chunk, $cOTLdata[$k]);
						$content[$k] = $chunk;
					}
					/* -- END OTL -- */ else {  // *OTL*
						$content[$k] = $chunk = str_replace("\xc2\xad", '', $chunk);
						$content[$k] = $chunk = str_replace(chr(194) . chr(160), chr(32), $chunk);
					} // *OTL*
				} elseif ($this->FontFamily != 'csymbol' && $this->FontFamily != 'czapfdingbats') {
					$content[$k] = $chunk = str_replace(chr(173), '', $chunk);
					$content[$k] = $chunk = str_replace(chr(160), chr(32), $chunk);
				}
				$contentWidth += $this->GetStringWidth($chunk, true, (isset($cOTLdata[$k]) ? $cOTLdata[$k] : false), $this->textvar) * _MPDFK;
			} elseif (isset($this->objectbuffer[$k]) && $this->objectbuffer[$k]) {
				// LIST MARKERS	// mPDF 6  Lists
				if ($this->objectbuffer[$k]['type'] == 'image' && isset($this->objectbuffer[$k]['listmarker']) && $this->objectbuffer[$k]['listmarker'] && $this->objectbuffer[$k]['listmarkerposition'] == 'outside') {
					// do nothing
				} else {
					$contentWidth += $this->objectbuffer[$k]['OUTER-WIDTH'] * _MPDFK;
				}
			}
		}

		if (isset($font[count($font) - 1])) {
			$lastfontreqstyle = (isset($font[count($font) - 1]['ReqFontStyle']) ? $font[count($font) - 1]['ReqFontStyle'] : '');
			$lastfontstyle = (isset($font[count($font) - 1]['style']) ? $font[count($font) - 1]['style'] : '');
		} else {
			$lastfontreqstyle = null;
			$lastfontstyle = null;
		}
		if ($blockdir == 'ltr' && strpos($lastfontreqstyle, "I") !== false && strpos($lastfontstyle, "I") === false) { // Artificial italic
			$lastitalic = $this->FontSize * 0.15 * _MPDFK;
		} else {
			$lastitalic = 0;
		}

		// Get PAGEBREAK TO TEST for height including the bottom border/padding
		$check_h = max($this->divheight, $stackHeight);

		// This fixes a proven bug...
		if ($endofblock && $newblock && $blockstate == 0 && !$content) {
			$check_h = 0;
		}
		// but ? needs to fix potentially more widespread...
		//	if (!$content) {  $check_h = 0; }

		if ($this->blklvl > 0 && !$is_table) {
			if ($endofblock && $blockstate > 1) {
				if ($this->blk[$this->blklvl]['page_break_after_avoid']) {
					$check_h += $stackHeight;
				}
				$check_h += ($this->blk[$this->blklvl]['padding_bottom'] + $this->blk[$this->blklvl]['border_bottom']['w']);
			}
			if (($newblock && ($blockstate == 1 || $blockstate == 3) && $lineCount == 0) || ($endofblock && $blockstate == 3 && $lineCount == 0)) {
				$check_h += ($this->blk[$this->blklvl]['padding_top'] + $this->blk[$this->blklvl]['margin_top'] + $this->blk[$this->blklvl]['border_top']['w']);
			}
		}

		// Force PAGE break if column height cannot take check-height
		if ($this->ColActive && $check_h > ($this->PageBreakTrigger - $this->y0)) {
			$this->SetCol($this->NbCol - 1);
		}

		// Avoid just border/background-color moved on to next page
		if ($endofblock && $blockstate > 1 && !$content) {
			$buff = $this->margBuffer;
		} else {
			$buff = 0;
		}


		// PAGEBREAK
		if (!$is_table && ($this->y + $check_h) > ($this->PageBreakTrigger + $buff) and ! $this->InFooter and $this->AcceptPageBreak()) {
			$bak_x = $this->x; //Current X position
			// WORD SPACING
			$ws = $this->ws; //Word Spacing
			$charspacing = $this->charspacing; //Character Spacing
			$this->ResetSpacing();

			$this->AddPage($this->CurOrientation);

			$this->x = $bak_x;
			// Added to correct for OddEven Margins
			$currentx += $this->MarginCorrection;
			$this->x += $this->MarginCorrection;

			// WORD SPACING
			$this->SetSpacing($charspacing, $ws);
		}


		/* -- COLUMNS -- */
		// COLS
		// COLUMN CHANGE
		if ($this->CurrCol != $oldcolumn) {
			$currentx += $this->ChangeColumn * ($this->ColWidth + $this->ColGap);
			$this->x += $this->ChangeColumn * ($this->ColWidth + $this->ColGap);
			$oldcolumn = $this->CurrCol;
		}


		if ($this->ColActive && !$is_table) {
			$this->breakpoints[$this->CurrCol][] = $this->y;
		}
		/* -- END COLUMNS -- */

		// TOP MARGIN
		if ($newblock && ($blockstate == 1 || $blockstate == 3) && ($this->blk[$this->blklvl]['margin_top']) && $lineCount == 0 && !$is_table) {
			$this->DivLn($this->blk[$this->blklvl]['margin_top'], $this->blklvl - 1, true, $this->blk[$this->blklvl]['margin_collapse']);
			if ($this->ColActive) {
				$this->breakpoints[$this->CurrCol][] = $this->y;
			} // *COLUMNS*
		}

		if ($newblock && ($blockstate == 1 || $blockstate == 3) && $lineCount == 0 && !$is_table) {
			$this->blk[$this->blklvl]['y0'] = $this->y;
			$this->blk[$this->blklvl]['startpage'] = $this->page;
			if ($this->blk[$this->blklvl]['float']) {
				$this->blk[$this->blklvl]['float_start_y'] = $this->y;
			}
			if ($this->ColActive) {
				$this->breakpoints[$this->CurrCol][] = $this->y;
			} // *COLUMNS*
		}

		// Paragraph INDENT
		$WidthCorrection = 0;
		if (($newblock) && ($blockstate == 1 || $blockstate == 3) && isset($this->blk[$this->blklvl]['text_indent']) && ($lineCount == 0) && (!$is_table) && ($align != 'C')) {
			$ti = $this->ConvertSize($this->blk[$this->blklvl]['text_indent'], $this->blk[$this->blklvl]['inner_width'], $this->blk[$this->blklvl]['InlineProperties']['size'], false);  // mPDF 5.7.4
			$WidthCorrection = ($ti * _MPDFK);
		}


		// PADDING and BORDER spacing/fill
		if (($newblock) && ($blockstate == 1 || $blockstate == 3) && (($this->blk[$this->blklvl]['padding_top']) || ($this->blk[$this->blklvl]['border_top'])) && ($lineCount == 0) && (!$is_table)) {
			// $state = 0 normal; 1 top; 2 bottom; 3 top and bottom
			$this->DivLn($this->blk[$this->blklvl]['padding_top'] + $this->blk[$this->blklvl]['border_top']['w'], -3, true, false, 1);
			if ($this->ColActive) {
				$this->breakpoints[$this->CurrCol][] = $this->y;
			} // *COLUMNS*
			$this->x = $currentx;
		}


		// Added mPDF 3.0 Float DIV
		$fpaddingR = 0;
		$fpaddingL = 0;
		/* -- CSS-FLOAT -- */
		if (count($this->floatDivs)) {
			list($l_exists, $r_exists, $l_max, $r_max, $l_width, $r_width) = $this->GetFloatDivInfo($this->blklvl);
			if ($r_exists) {
				$fpaddingR = $r_width;
			}
			if ($l_exists) {
				$fpaddingL = $l_width;
			}
		}
		/* -- END CSS-FLOAT -- */

		$usey = $this->y + 0.002;
		if (($newblock) && ($blockstate == 1 || $blockstate == 3) && ($lineCount == 0)) {
			$usey += $this->blk[$this->blklvl]['margin_top'] + $this->blk[$this->blklvl]['padding_top'] + $this->blk[$this->blklvl]['border_top']['w'];
		}
		/* -- CSS-IMAGE-FLOAT -- */
		// If float exists at this level
		if (isset($this->floatmargins['R']) && $usey <= $this->floatmargins['R']['y1'] && $usey >= $this->floatmargins['R']['y0'] && !$this->floatmargins['R']['skipline']) {
			$fpaddingR += $this->floatmargins['R']['w'];
		}
		if (isset($this->floatmargins['L']) && $usey <= $this->floatmargins['L']['y1'] && $usey >= $this->floatmargins['L']['y0'] && !$this->floatmargins['L']['skipline']) {
			$fpaddingL += $this->floatmargins['L']['w'];
		}
		/* -- END CSS-IMAGE-FLOAT -- */


		if ($content) {

			// In FinishFlowing Block no lines are justified as it is always last line
			// but if CJKorphan has allowed content width to go over max width, use J charspacing to compress line
			// JUSTIFICATION J - NOT!
			$nb_carac = 0;
			$nb_spaces = 0;
			$jcharspacing = 0;
			$jkashida = 0;
			$jws = 0;
			$inclCursive = false;
			$dottab = false;
			foreach ($content as $k => $chunk) {
				if (!isset($this->objectbuffer[$k]) || (isset($this->objectbuffer[$k]) && !$this->objectbuffer[$k])) {
					$nb_carac += mb_strlen($chunk, $this->mb_enc);
					$nb_spaces += mb_substr_count($chunk, ' ', $this->mb_enc);
					// mPDF 6
					// Use GPOS OTL
					$this->restoreFont($font[$k], false);
					if (isset($this->CurrentFont['useOTL']) && $this->CurrentFont['useOTL']) {
						if (isset($cOTLdata[$k]['group']) && $cOTLdata[$k]['group']) {
							$nb_marks = substr_count($cOTLdata[$k]['group'], 'M');
							$nb_carac -= $nb_marks;
						}
						if (preg_match("/([" . $this->pregCURSchars . "])/u", $chunk)) {
							$inclCursive = true;
						}
					}
				} else {
					$nb_carac ++;  // mPDF 6 allow spacing for inline object
					if ($this->objectbuffer[$k]['type'] == 'dottab') {
						$dottab = $this->objectbuffer[$k]['outdent'];
					}
				}
			}

			// DIRECTIONALITY RTL
			$chunkorder = range(0, count($content) - 1); // mPDF 6
			/* -- OTL -- */
			// mPDF 6
			if ($blockdir == 'rtl' || $this->biDirectional) {
				$this->otl->_bidiReorder($chunkorder, $content, $cOTLdata, $blockdir);
				// From this point on, $content and $cOTLdata may contain more elements (and re-ordered) compared to
				// $this->objectbuffer and $font ($chunkorder contains the mapping)
			}
			/* -- END OTL -- */

			// Remove any XAdvance from OTL data at end of line
			// And correct for XPlacement on last character
			// BIDI is applied
			foreach ($chunkorder AS $aord => $k) {
				if (count($cOTLdata)) {
					$this->restoreFont($font[$k], false);
					// ...FinishFlowingBlock...
					if ($aord == count($chunkorder) - 1 && isset($cOTLdata[$aord]['group'])) { // Last chunk on line
						$nGPOS = strlen($cOTLdata[$aord]['group']) - 1; // Last character
						if (isset($cOTLdata[$aord]['GPOSinfo'][$nGPOS]['XAdvanceL']) || isset($cOTLdata[$aord]['GPOSinfo'][$nGPOS]['XAdvanceR'])) {
							if (isset($cOTLdata[$aord]['GPOSinfo'][$nGPOS]['XAdvanceL'])) {
								$w = $cOTLdata[$aord]['GPOSinfo'][$nGPOS]['XAdvanceL'] * 1000 / $this->CurrentFont['unitsPerEm'];
							} else {
								$w = $cOTLdata[$aord]['GPOSinfo'][$nGPOS]['XAdvanceR'] * 1000 / $this->CurrentFont['unitsPerEm'];
							}
							$w *= ($this->FontSize / 1000);
							$contentWidth -= $w * _MPDFK;
							$cOTLdata[$aord]['GPOSinfo'][$nGPOS]['XAdvanceL'] = 0;
							$cOTLdata[$aord]['GPOSinfo'][$nGPOS]['XAdvanceR'] = 0;
						}

						// If last character has an XPlacement set, adjust width calculation, and add to XAdvance to account for it
						if (isset($cOTLdata[$aord]['GPOSinfo'][$nGPOS]['XPlacement'])) {
							$w = -$cOTLdata[$aord]['GPOSinfo'][$nGPOS]['XPlacement'] * 1000 / $this->CurrentFont['unitsPerEm'];
							$w *= ($this->FontSize / 1000);
							$contentWidth -= $w * _MPDFK;
							$cOTLdata[$aord]['GPOSinfo'][$nGPOS]['XAdvanceL'] = $cOTLdata[$aord]['GPOSinfo'][$nGPOS]['XPlacement'];
							$cOTLdata[$aord]['GPOSinfo'][$nGPOS]['XAdvanceR'] = $cOTLdata[$aord]['GPOSinfo'][$nGPOS]['XPlacement'];
						}
					}
				}
			}

			// if it's justified, we need to find the char/word spacing (or if orphans have allowed length of line to go over the maxwidth)
			// If "orphans" in fact is just a final space - ignore this
			$lastchar = mb_substr($content[(count($chunkorder) - 1)], mb_strlen($content[(count($chunkorder) - 1)], $this->mb_enc) - 1, 1, $this->mb_enc);
			if (preg_match("/[" . $this->CJKoverflow . "]/u", $lastchar)) {
				$CJKoverflow = true;
			} else {
				$CJKoverflow = false;
			}
			if ((((($contentWidth + $lastitalic) > $maxWidth) && ($content[(count($chunkorder) - 1)] != ' ') ) ||
				(!$endofblock && $align == 'J' && ($next == 'image' || $next == 'select' || $next == 'input' || $next == 'textarea' || ($next == 'br' && $this->justifyB4br)))) && !($CJKoverflow && $this->allowCJKoverflow)) {
				// WORD SPACING
				list($jcharspacing, $jws, $jkashida) = $this->GetJspacing($nb_carac, $nb_spaces, ($maxWidth - $lastitalic - $contentWidth - $WidthCorrection - (($this->cMarginL + $this->cMarginR) * _MPDFK) - ($paddingL + $paddingR + (($fpaddingL + $fpaddingR) * _MPDFK) )), $inclCursive, $cOTLdata);
			}
			/* -- CJK-FONTS -- */ elseif ($this->checkCJK && $align == 'J' && $CJKoverflow && $this->allowCJKoverflow && $this->CJKforceend) {
				// force-end overhang
				$hanger = mb_substr($content[(count($chunkorder) - 1)], mb_strlen($content[(count($chunkorder) - 1)], $this->mb_enc) - 1, 1, $this->mb_enc);
				if (preg_match("/[" . $this->CJKoverflow . "]/u", $hanger)) {
					$content[(count($chunkorder) - 1)] = mb_substr($content[(count($chunkorder) - 1)], 0, mb_strlen($content[(count($chunkorder) - 1)], $this->mb_enc) - 1, $this->mb_enc);
					$this->restoreFont($font[$chunkorder[count($chunkorder) - 1]], false);
					$contentWidth -= $this->GetStringWidth($hanger) * _MPDFK;
					$nb_carac -= 1;
					list($jcharspacing, $jws, $jkashida) = $this->GetJspacing($nb_carac, $nb_spaces, ($maxWidth - $lastitalic - $contentWidth - $WidthCorrection - (($this->cMarginL + $this->cMarginR) * _MPDFK) - ($paddingL + $paddingR + (($fpaddingL + $fpaddingR) * _MPDFK) )), $inclCursive, $cOTLdata);
				}
			}
			/* -- END CJK-FONTS -- */

			// Check if will fit at word/char spacing of previous line - if so continue it
			// but only allow a maximum of $this->jSmaxWordLast and $this->jSmaxCharLast
			elseif ($contentWidth < ($maxWidth - $lastitalic - $WidthCorrection - (($this->cMarginL + $this->cMarginR) * _MPDFK) - ($paddingL + $paddingR + (($fpaddingL + $fpaddingR) * _MPDFK))) && !$this->fixedlSpacing) {
				if ($this->ws > $this->jSmaxWordLast) {
					$jws = $this->jSmaxWordLast;
				}
				if ($this->charspacing > $this->jSmaxCharLast) {
					$jcharspacing = $this->jSmaxCharLast;
				}
				$check = $maxWidth - $lastitalic - $WidthCorrection - $contentWidth - (($this->cMarginL + $this->cMarginR) * _MPDFK) - ($paddingL + $paddingR + (($fpaddingL + $fpaddingR) * _MPDFK) ) - ( $jcharspacing * $nb_carac) - ( $jws * $nb_spaces);
				if ($check <= 0) {
					$jcharspacing = 0;
					$jws = 0;
				}
			}

			$empty = $maxWidth - $lastitalic - $WidthCorrection - $contentWidth - (($this->cMarginL + $this->cMarginR) * _MPDFK) - ($paddingL + $paddingR + (($fpaddingL + $fpaddingR) * _MPDFK) );


			$empty -= ($jcharspacing * ($nb_carac - 1)); // mPDF 6 nb_carac MINUS 1
			$empty -= ($jws * $nb_spaces);
			$empty -= ($jkashida);

			$empty /= _MPDFK;

			if (!$is_table) {
				$this->maxPosR = max($this->maxPosR, ($this->w - $this->rMargin - $this->blk[$this->blklvl]['outer_right_margin'] - $empty));
				$this->maxPosL = min($this->maxPosL, ($this->lMargin + $this->blk[$this->blklvl]['outer_left_margin'] + $empty));
			}

			$arraysize = count($chunkorder);

			$margins = ($this->cMarginL + $this->cMarginR) + ($ipaddingL + $ipaddingR + $fpaddingR + $fpaddingR );

			if (!$is_table) {
				$this->DivLn($stackHeight, $this->blklvl, false);
			} // false -> don't advance y

			$this->x = $currentx + $this->cMarginL + $ipaddingL + $fpaddingL;
			if ($dottab !== false && $blockdir == 'rtl') {
				$this->x -= $dottab;
			} elseif ($align == 'R') {
				$this->x += $empty;
			} elseif ($align == 'J' && $blockdir == 'rtl') {
				$this->x += $empty;
			} elseif ($align == 'C') {
				$this->x += ($empty / 2);
			}

			// Paragraph INDENT
			$WidthCorrection = 0;
			if (($newblock) && ($blockstate == 1 || $blockstate == 3) && isset($this->blk[$this->blklvl]['text_indent']) && ($lineCount == 0) && (!$is_table) && ($align != 'C')) {
				$ti = $this->ConvertSize($this->blk[$this->blklvl]['text_indent'], $this->blk[$this->blklvl]['inner_width'], $this->blk[$this->blklvl]['InlineProperties']['size'], false);  // mPDF 5.7.4
				if ($blockdir != 'rtl') {
					$this->x += $ti;
				} // mPDF 6
			}

			foreach ($chunkorder AS $aord => $k) { // mPDF 5.7
				$chunk = $content[$aord];
				if (isset($this->objectbuffer[$k]) && $this->objectbuffer[$k]) {

					$xadj = $this->x - $this->objectbuffer[$k]['OUTER-X'];
					$this->objectbuffer[$k]['OUTER-X'] += $xadj;
					$this->objectbuffer[$k]['BORDER-X'] += $xadj;
					$this->objectbuffer[$k]['INNER-X'] += $xadj;

					if ($this->objectbuffer[$k]['type'] == 'listmarker') {
						$this->objectbuffer[$k]['lineBox'] = $lineBox[-1]; // Block element details for glyph-origin
					}
					$yadj = $this->y - $this->objectbuffer[$k]['OUTER-Y'];
					if ($this->objectbuffer[$k]['type'] == 'dottab') { // mPDF 6 DOTTAB
						$this->objectbuffer[$k]['lineBox'] = $lineBox[$k]; // element details for glyph-origin
					}
					if ($this->objectbuffer[$k]['type'] != 'dottab') { // mPDF 6 DOTTAB
						$yadj += $lineBox[$k]['top'];
					}
					$this->objectbuffer[$k]['OUTER-Y'] += $yadj;
					$this->objectbuffer[$k]['BORDER-Y'] += $yadj;
					$this->objectbuffer[$k]['INNER-Y'] += $yadj;
				}

				$this->restoreFont($font[$k]);  // mPDF 5.7

				if ($is_table && substr($align, 0, 1) == 'D' && $aord == 0) {
					$dp = $this->decimal_align[substr($align, 0, 2)];
					$s = preg_split('/' . preg_quote($dp, '/') . '/', $content[0], 2);  // ? needs to be /u if not core
					$s0 = $this->GetStringWidth($s[0], false);
					$this->x += ($this->decimal_offset - $s0);
				}

				$this->SetSpacing(($this->fixedlSpacing * _MPDFK) + $jcharspacing, ($this->fixedlSpacing + $this->minwSpacing) * _MPDFK + $jws);
				$this->fixedlSpacing = false;
				$this->minwSpacing = 0;

				$save_vis = $this->visibility;
				if (isset($this->textparam['visibility']) && $this->textparam['visibility'] && $this->textparam['visibility'] != $this->visibility) {
					$this->SetVisibility($this->textparam['visibility']);
				}

				// *********** SPAN BACKGROUND COLOR ***************** //
				if (isset($this->spanbgcolor) && $this->spanbgcolor) {
					$cor = $this->spanbgcolorarray;
					$this->SetFColor($cor);
					$save_fill = $fill;
					$spanfill = 1;
					$fill = 1;
				}
				if (!empty($this->spanborddet)) {
					if (strpos($contentB[$k], 'L') !== false && isset($this->spanborddet['L']))
						$this->x += $this->spanborddet['L']['w'];
					if (strpos($contentB[$k], 'L') === false)
						$this->spanborddet['L']['s'] = $this->spanborddet['L']['w'] = 0;
					if (strpos($contentB[$k], 'R') === false)
						$this->spanborddet['R']['s'] = $this->spanborddet['R']['w'] = 0;
				}
				// WORD SPACING
				// mPDF 5.7.1
				$stringWidth = $this->GetStringWidth($chunk, true, (isset($cOTLdata[$aord]) ? $cOTLdata[$aord] : false), $this->textvar);
				$nch = mb_strlen($chunk, $this->mb_enc);
				// Use GPOS OTL
				if (isset($this->CurrentFont['useOTL']) && $this->CurrentFont['useOTL']) {
					if (isset($cOTLdata[$aord]['group']) && $cOTLdata[$aord]['group']) {
						$nch -= substr_count($cOTLdata[$aord]['group'], 'M');
					}
				}
				$stringWidth += ( $this->charspacing * $nch / _MPDFK );

				$stringWidth += ( $this->ws * mb_substr_count($chunk, ' ', $this->mb_enc) / _MPDFK );

				if (isset($this->objectbuffer[$k])) {
					if ($this->objectbuffer[$k]['type'] == 'dottab') {
						$this->objectbuffer[$k]['OUTER-WIDTH'] +=$empty;
						$this->objectbuffer[$k]['OUTER-WIDTH'] +=$this->objectbuffer[$k]['outdent'];
					}
					// LIST MARKERS	// mPDF 6  Lists
					if ($this->objectbuffer[$k]['type'] == 'image' && isset($this->objectbuffer[$k]['listmarker']) && $this->objectbuffer[$k]['listmarker'] && $this->objectbuffer[$k]['listmarkerposition'] == 'outside') {
						// do nothing
					} else {
						$stringWidth = $this->objectbuffer[$k]['OUTER-WIDTH'];
					}
				}

				if ($stringWidth == 0) {
					$stringWidth = 0.000001;
				}
				if ($aord == $arraysize - 1) { // mPDF 5.7
					// mPDF 5.7.1
					if ($this->checkCJK && $CJKoverflow && $align == 'J' && $this->allowCJKoverflow && $hanger && $this->CJKforceend) {
						// force-end overhang
						$this->Cell($stringWidth, $stackHeight, $chunk, '', 0, '', $fill, $this->HREF, $currentx, 0, 0, 'M', $fill, true, (isset($cOTLdata[$aord]) ? $cOTLdata[$aord] : false), $this->textvar, (isset($lineBox[$k]) ? $lineBox[$k] : false));  // mPDF 5.7.1
						$this->Cell($this->GetStringWidth($hanger), $stackHeight, $hanger, '', 1, '', $fill, $this->HREF, $currentx, 0, 0, 'M', $fill, true, (isset($cOTLdata[$aord]) ? $cOTLdata[$aord] : false), $this->textvar, (isset($lineBox[$k]) ? $lineBox[$k] : false)); // mPDF 5.7.1
					} else {
						$this->Cell($stringWidth, $stackHeight, $chunk, '', 1, '', $fill, $this->HREF, $currentx, 0, 0, 'M', $fill, true, (isset($cOTLdata[$aord]) ? $cOTLdata[$aord] : false), $this->textvar, (isset($lineBox[$k]) ? $lineBox[$k] : false)); // mPDF 5.7.1
					}
				} else
					$this->Cell($stringWidth, $stackHeight, $chunk, '', 0, '', $fill, $this->HREF, 0, 0, 0, 'M', $fill, true, (isset($cOTLdata[$aord]) ? $cOTLdata[$aord] : false), $this->textvar, (isset($lineBox[$k]) ? $lineBox[$k] : false)); //first or middle part	// mPDF 5.7.1


				if (!empty($this->spanborddet)) {
					if (strpos($contentB[$k], 'R') !== false && $aord != $arraysize - 1)
						$this->x += $this->spanborddet['R']['w'];
				}
				// *********** SPAN BACKGROUND COLOR OFF - RESET BLOCK BGCOLOR ***************** //
				if (isset($spanfill) && $spanfill) {
					$fill = $save_fill;
					$spanfill = 0;
					if ($fill) {
						$this->SetFColor($bcor);
					}
				}
				if (isset($this->textparam['visibility']) && $this->textparam['visibility'] && $this->visibility != $save_vis) {
					$this->SetVisibility($save_vis);
				}
			}

			$this->printobjectbuffer($is_table, $blockdir);
			$this->objectbuffer = array();
			$this->ResetSpacing();
		} // END IF CONTENT

		/* -- CSS-IMAGE-FLOAT -- */
		// Update values if set to skipline
		if ($this->floatmargins) {
			$this->_advanceFloatMargins();
		}


		if ($endofblock && $blockstate > 1) {
			// If float exists at this level
			if (isset($this->floatmargins['R']['y1'])) {
				$fry1 = $this->floatmargins['R']['y1'];
			} else {
				$fry1 = 0;
			}
			if (isset($this->floatmargins['L']['y1'])) {
				$fly1 = $this->floatmargins['L']['y1'];
			} else {
				$fly1 = 0;
			}
			if ($this->y < $fry1 || $this->y < $fly1) {
				$drop = max($fry1, $fly1) - $this->y;
				$this->DivLn($drop);
				$this->x = $currentx;
			}
		}
		/* -- END CSS-IMAGE-FLOAT -- */


		// PADDING and BORDER spacing/fill
		if ($endofblock && ($blockstate > 1) && ($this->blk[$this->blklvl]['padding_bottom'] || $this->blk[$this->blklvl]['border_bottom'] || $this->blk[$this->blklvl]['css_set_height']) && (!$is_table)) {
			// If CSS height set, extend bottom - if on same page as block started, and CSS HEIGHT > actual height,
			// and does not force pagebreak
			$extra = 0;
			if (isset($this->blk[$this->blklvl]['css_set_height']) && $this->blk[$this->blklvl]['css_set_height'] && $this->blk[$this->blklvl]['startpage'] == $this->page) {
				// predicted height
				$h1 = ($this->y - $this->blk[$this->blklvl]['y0']) + $this->blk[$this->blklvl]['padding_bottom'] + $this->blk[$this->blklvl]['border_bottom']['w'];
				if ($h1 < ($this->blk[$this->blklvl]['css_set_height'] + $this->blk[$this->blklvl]['padding_bottom'] + $this->blk[$this->blklvl]['padding_top'])) {
					$extra = ($this->blk[$this->blklvl]['css_set_height'] + $this->blk[$this->blklvl]['padding_bottom'] + $this->blk[$this->blklvl]['padding_top']) - $h1;
				}
				if ($this->y + $this->blk[$this->blklvl]['padding_bottom'] + $this->blk[$this->blklvl]['border_bottom']['w'] + $extra > $this->PageBreakTrigger) {
					$extra = $this->PageBreakTrigger - ($this->y + $this->blk[$this->blklvl]['padding_bottom'] + $this->blk[$this->blklvl]['border_bottom']['w']);
				}
			}

			// $state = 0 normal; 1 top; 2 bottom; 3 top and bottom
			$this->DivLn($this->blk[$this->blklvl]['padding_bottom'] + $this->blk[$this->blklvl]['border_bottom']['w'] + $extra, -3, true, false, 2);
			$this->x = $currentx;

			if ($this->ColActive) {
				$this->breakpoints[$this->CurrCol][] = $this->y;
			} // *COLUMNS*
		}

		// SET Bottom y1 of block (used for painting borders)
		if (($endofblock) && ($blockstate > 1) && (!$is_table)) {
			$this->blk[$this->blklvl]['y1'] = $this->y;
		}

		// BOTTOM MARGIN
		if (($endofblock) && ($blockstate > 1) && ($this->blk[$this->blklvl]['margin_bottom']) && (!$is_table)) {
			if ($this->y + $this->blk[$this->blklvl]['margin_bottom'] < $this->PageBreakTrigger and ! $this->InFooter) {
				$this->DivLn($this->blk[$this->blklvl]['margin_bottom'], $this->blklvl - 1, true, $this->blk[$this->blklvl]['margin_collapse']);
				if ($this->ColActive) {
					$this->breakpoints[$this->CurrCol][] = $this->y;
				} // *COLUMNS*
			}
		}

		// Reset lineheight
		$stackHeight = $this->divheight;
	}

	function printobjectbuffer($is_table = false, $blockdir = false)
	{
		if (!$blockdir) {
			$blockdir = $this->directionality;
		}
		if ($is_table && $this->shrin_k > 1) {
			$k = $this->shrin_k;
		} else {
			$k = 1;
		}
		$save_y = $this->y;
		$save_x = $this->x;
		$save_currentfontfamily = $this->FontFamily;
		$save_currentfontsize = $this->FontSizePt;
		$save_currentfontstyle = $this->FontStyle;
		if ($blockdir == 'rtl') {
			$rtlalign = 'R';
		} else {
			$rtlalign = 'L';
		}
		foreach ($this->objectbuffer AS $ib => $objattr) {
			if ($objattr['type'] == 'bookmark' || $objattr['type'] == 'indexentry' || $objattr['type'] == 'toc') {
				$x = $objattr['OUTER-X'];
				$y = $objattr['OUTER-Y'];
				$this->y = $y - $this->FontSize / 2;
				$this->x = $x;
				if ($objattr['type'] == 'bookmark') {
					$this->Bookmark($objattr['CONTENT'], $objattr['bklevel'], $y - $this->FontSize);
				} // *BOOKMARKS*
				if ($objattr['type'] == 'indexentry') {
					$this->IndexEntry($objattr['CONTENT']);
				} // *INDEX*
				if ($objattr['type'] == 'toc') {
					$this->TOC_Entry($objattr['CONTENT'], $objattr['toclevel'], (isset($objattr['toc_id']) ? $objattr['toc_id'] : ''));
				} // *TOC*
			}
			/* -- ANNOTATIONS -- */ elseif ($objattr['type'] == 'annot') {
				if ($objattr['POS-X']) {
					$x = $objattr['POS-X'];
				} elseif ($this->annotMargin <> 0) {
					$x = -$objattr['OUTER-X'];
				} else {
					$x = $objattr['OUTER-X'];
				}
				if ($objattr['POS-Y']) {
					$y = $objattr['POS-Y'];
				} else {
					$y = $objattr['OUTER-Y'] - $this->FontSize / 2;
				}
				// Create a dummy entry in the _out/columnBuffer with position sensitive data,
				// linking $y-1 in the Columnbuffer with entry in $this->columnAnnots
				// and when columns are split in length will not break annotation from current line
				$this->y = $y - 1;
				$this->x = $x - 1;
				$this->Line($x - 1, $y - 1, $x - 1, $y - 1);
				$this->Annotation($objattr['CONTENT'], $x, $y, $objattr['ICON'], $objattr['AUTHOR'], $objattr['SUBJECT'], $objattr['OPACITY'], $objattr['COLOR'], (isset($objattr['POPUP']) ? $objattr['POPUP'] : ''), (isset($objattr['FILE']) ? $objattr['FILE'] : ''));
			}
			/* -- END ANNOTATIONS -- */ else {
				$y = $objattr['OUTER-Y'];
				$x = $objattr['OUTER-X'];
				$w = $objattr['OUTER-WIDTH'];
				$h = $objattr['OUTER-HEIGHT'];
				if (isset($objattr['text'])) {
					$texto = $objattr['text'];
				}
				$this->y = $y;
				$this->x = $x;
				if (isset($objattr['fontfamily'])) {
					$this->SetFont($objattr['fontfamily'], '', $objattr['fontsize']);
				}
			}

			// HR
			if ($objattr['type'] == 'hr') {
				$this->SetDColor($objattr['color']);
				switch ($objattr['align']) {
					case 'C':
						$empty = $objattr['OUTER-WIDTH'] - $objattr['INNER-WIDTH'];
						$empty /= 2;
						$x += $empty;
						break;
					case 'R':
						$empty = $objattr['OUTER-WIDTH'] - $objattr['INNER-WIDTH'];
						$x += $empty;
						break;
				}
				$oldlinewidth = $this->LineWidth;
				$this->SetLineWidth($objattr['linewidth'] / $k);
				$this->y += ($objattr['linewidth'] / 2) + $objattr['margin_top'] / $k;
				$this->Line($x, $this->y, $x + $objattr['INNER-WIDTH'], $this->y);
				$this->SetLineWidth($oldlinewidth);
				$this->SetDColor($this->ConvertColor(0));
			}
			// IMAGE
			if ($objattr['type'] == 'image') {
				// mPDF 5.7.3 TRANSFORMS
				if (isset($objattr['transform'])) {
					$this->_out("\n" . '% BTR'); // Begin Transform
				}
				if (isset($objattr['z-index']) && $objattr['z-index'] > 0 && $this->current_layer == 0) {
					$this->BeginLayer($objattr['z-index']);
				}
				if (isset($objattr['visibility']) && $objattr['visibility'] != 'visible' && $objattr['visibility']) {
					$this->SetVisibility($objattr['visibility']);
				}
				if (isset($objattr['opacity'])) {
					$this->SetAlpha($objattr['opacity']);
				}

				$obiw = $objattr['INNER-WIDTH'];
				$obih = $objattr['INNER-HEIGHT'];
				$sx = $objattr['INNER-WIDTH'] * _MPDFK / $objattr['orig_w'];
				$sy = abs($objattr['INNER-HEIGHT']) * _MPDFK / abs($objattr['orig_h']);
				$sx = ($objattr['INNER-WIDTH'] * _MPDFK / $objattr['orig_w']);
				$sy = ($objattr['INNER-HEIGHT'] * _MPDFK / $objattr['orig_h']);

				$rotate = 0;
				if (isset($objattr['ROTATE'])) {
					$rotate = $objattr['ROTATE'];
				}
				if ($rotate == 90) {
					// Clockwise
					$obiw = $objattr['INNER-HEIGHT'];
					$obih = $objattr['INNER-WIDTH'];
					$tr = $this->transformTranslate(0, -$objattr['INNER-WIDTH'], true);
					$tr .= ' ' . $this->transformRotate(90, $objattr['INNER-X'], ($objattr['INNER-Y'] + $objattr['INNER-WIDTH']), true);
					$sx = $obiw * _MPDFK / $objattr['orig_h'];
					$sy = $obih * _MPDFK / $objattr['orig_w'];
				} elseif ($rotate == -90 || $rotate == 270) {
					// AntiClockwise
					$obiw = $objattr['INNER-HEIGHT'];
					$obih = $objattr['INNER-WIDTH'];
					$tr = $this->transformTranslate($objattr['INNER-WIDTH'], ($objattr['INNER-HEIGHT'] - $objattr['INNER-WIDTH']), true);
					$tr .= ' ' . $this->transformRotate(-90, $objattr['INNER-X'], ($objattr['INNER-Y'] + $objattr['INNER-WIDTH']), true);
					$sx = $obiw * _MPDFK / $objattr['orig_h'];
					$sy = $obih * _MPDFK / $objattr['orig_w'];
				} elseif ($rotate == 180) {
					// Mirror
					$tr = $this->transformTranslate($objattr['INNER-WIDTH'], -$objattr['INNER-HEIGHT'], true);
					$tr .= ' ' . $this->transformRotate(180, $objattr['INNER-X'], ($objattr['INNER-Y'] + $objattr['INNER-HEIGHT']), true);
				} else {
					$tr = '';
				}
				$tr = trim($tr);
				if ($tr) {
					$tr .= ' ';
				}
				$gradmask = '';

				// mPDF 5.7.3 TRANSFORMS
				$tr2 = '';
				if (isset($objattr['transform'])) {
					$maxsize_x = $w;
					$maxsize_y = $h;
					$cx = $x + $w / 2;
					$cy = $y + $h / 2;
					preg_match_all('/(translatex|translatey|translate|scalex|scaley|scale|rotate|skewX|skewY|skew)\((.*?)\)/is', $objattr['transform'], $m);
					if (count($m[0])) {
						for ($i = 0; $i < count($m[0]); $i++) {
							$c = strtolower($m[1][$i]);
							$v = trim($m[2][$i]);
							$vv = preg_split('/[ ,]+/', $v);
							if ($c == 'translate' && count($vv)) {
								$translate_x = $this->ConvertSize($vv[0], $maxsize_x, false, false);
								if (count($vv) == 2) {
									$translate_y = $this->ConvertSize($vv[1], $maxsize_y, false, false);
								} else {
									$translate_y = 0;
								}
								$tr2 .= $this->transformTranslate($translate_x, $translate_y, true) . ' ';
							} elseif ($c == 'translatex' && count($vv)) {
								$translate_x = $this->ConvertSize($vv[0], $maxsize_x, false, false);
								$tr2 .= $this->transformTranslate($translate_x, 0, true) . ' ';
							} elseif ($c == 'translatey' && count($vv)) {
								$translate_y = $this->ConvertSize($vv[1], $maxsize_y, false, false);
								$tr2 .= $this->transformTranslate(0, $translate_y, true) . ' ';
							} elseif ($c == 'scale' && count($vv)) {
								$scale_x = $vv[0] * 100;
								if (count($vv) == 2) {
									$scale_y = $vv[1] * 100;
								} else {
									$scale_y = $scale_x;
								}
								$tr2 .= $this->transformScale($scale_x, $scale_y, $cx, $cy, true) . ' ';
							} elseif ($c == 'scalex' && count($vv)) {
								$scale_x = $vv[0] * 100;
								$tr2 .= $this->transformScale($scale_x, 0, $cx, $cy, true) . ' ';
							} elseif ($c == 'scaley' && count($vv)) {
								$scale_y = $vv[1] * 100;
								$tr2 .= $this->transformScale(0, $scale_y, $cx, $cy, true) . ' ';
							} elseif ($c == 'skew' && count($vv)) {
								$angle_x = $this->ConvertAngle($vv[0], false);
								if (count($vv) == 2) {
									$angle_y = $this->ConvertAngle($vv[1], false);
								} else {
									$angle_y = 0;
								}
								$tr2 .= $this->transformSkew($angle_x, $angle_y, $cx, $cy, true) . ' ';
							} elseif ($c == 'skewx' && count($vv)) {
								$angle = $this->ConvertAngle($vv[0], false);
								$tr2 .= $this->transformSkew($angle, 0, $cx, $cy, true) . ' ';
							} elseif ($c == 'skewy' && count($vv)) {
								$angle = $this->ConvertAngle($vv[0], false);
								$tr2 .= $this->transformSkew(0, $angle, $cx, $cy, true) . ' ';
							} elseif ($c == 'rotate' && count($vv)) {
								$angle = $this->ConvertAngle($vv[0]);
								$tr2 .= $this->transformRotate($angle, $cx, $cy, true) . ' ';
							}
						}
					}
				}

				// LIST MARKERS (Images)	// mPDF 6  Lists
				if (isset($objattr['listmarker']) && $objattr['listmarker'] && $objattr['listmarkerposition'] == 'outside') {
					$mw = $objattr['OUTER-WIDTH'];
					//  NB If change marker-offset, also need to alter in function _getListMarkerWidth
					$adjx = $this->ConvertSize($this->list_marker_offset, $this->FontSize);
					if ($objattr['dir'] == 'rtl') {
						$objattr['INNER-X'] += $adjx;
					} else {
						$objattr['INNER-X'] -= $adjx;
						$objattr['INNER-X'] -= $mw;
					}
				}
				// mPDF 5.7.3 TRANSFORMS / BACKGROUND COLOR
				// Transform also affects image background
				if ($tr2) {
					$this->_out('q ' . $tr2 . ' ');
				}
				if (isset($objattr['bgcolor']) && $objattr['bgcolor']) {
					$bgcol = $objattr['bgcolor'];
					$this->SetFColor($bgcol);
					$this->Rect($x, $y, $w, $h, 'F');
					$this->SetFColor($this->ConvertColor(255));
				}
				if ($tr2) {
					$this->_out('Q');
				}

				/* -- BACKGROUNDS -- */
				if (isset($objattr['GRADIENT-MASK'])) {
					$g = $this->grad->parseMozGradient($objattr['GRADIENT-MASK']);
					if ($g) {
						$dummy = $this->grad->Gradient($objattr['INNER-X'], $objattr['INNER-Y'], $obiw, $obih, $g['type'], $g['stops'], $g['colorspace'], $g['coords'], $g['extend'], true, true);
						$gradmask = '/TGS' . count($this->gradients) . ' gs ';
					}
				}
				/* -- END BACKGROUNDS -- */
				/* -- IMAGES-WMF -- */
				if (isset($objattr['itype']) && $objattr['itype'] == 'wmf') {
					$outstring = sprintf('q ' . $tr . $tr2 . '%.3F 0 0 %.3F %.3F %.3F cm /FO%d Do Q', $sx, -$sy, $objattr['INNER-X'] * _MPDFK - $sx * $objattr['wmf_x'], (($this->h - $objattr['INNER-Y']) * _MPDFK) + $sy * $objattr['wmf_y'], $objattr['ID']); // mPDF 5.7.3 TRANSFORMS
				} else
				/* -- END IMAGES-WMF -- */
				if (isset($objattr['itype']) && $objattr['itype'] == 'svg') {
					$outstring = sprintf('q ' . $tr . $tr2 . '%.3F 0 0 %.3F %.3F %.3F cm /FO%d Do Q', $sx, -$sy, $objattr['INNER-X'] * _MPDFK - $sx * $objattr['wmf_x'], (($this->h - $objattr['INNER-Y']) * _MPDFK) + $sy * $objattr['wmf_y'], $objattr['ID']); // mPDF 5.7.3 TRANSFORMS
				} else {
					$outstring = sprintf("q " . $tr . $tr2 . "%.3F 0 0 %.3F %.3F %.3F cm " . $gradmask . "/I%d Do Q", $obiw * _MPDFK, $obih * _MPDFK, $objattr['INNER-X'] * _MPDFK, ($this->h - ($objattr['INNER-Y'] + $obih )) * _MPDFK, $objattr['ID']); // mPDF 5.7.3 TRANSFORMS
				}
				$this->_out($outstring);
				// LINK
				if (isset($objattr['link']))
					$this->Link($objattr['INNER-X'], $objattr['INNER-Y'], $objattr['INNER-WIDTH'], $objattr['INNER-HEIGHT'], $objattr['link']);
				if (isset($objattr['opacity'])) {
					$this->SetAlpha(1);
				}

				// mPDF 5.7.3 TRANSFORMS
				// Transform also affects image borders
				if ($tr2) {
					$this->_out('q ' . $tr2 . ' ');
				}
				if ((isset($objattr['border_top']) && $objattr['border_top'] > 0) || (isset($objattr['border_left']) && $objattr['border_left'] > 0) || (isset($objattr['border_right']) && $objattr['border_right'] > 0) || (isset($objattr['border_bottom']) && $objattr['border_bottom'] > 0)) {
					$this->PaintImgBorder($objattr, $is_table);
				}
				if ($tr2) {
					$this->_out('Q');
				}

				if (isset($objattr['visibility']) && $objattr['visibility'] != 'visible' && $objattr['visibility']) {
					$this->SetVisibility('visible');
				}
				if (isset($objattr['z-index']) && $objattr['z-index'] > 0 && $this->current_layer == 0) {
					$this->EndLayer();
				}
				// mPDF 5.7.3 TRANSFORMS
				if (isset($objattr['transform'])) {
					$this->_out("\n" . '% ETR'); // End Transform
				}
			}

			/* -- BARCODES -- */
			// BARCODE
			if ($objattr['type'] == 'barcode') {
				$bgcol = $this->ConvertColor(255);
				if (isset($objattr['bgcolor']) && $objattr['bgcolor']) {
					$bgcol = $objattr['bgcolor'];
				}
				$col = $this->ConvertColor(0);
				if (isset($objattr['color']) && $objattr['color']) {
					$col = $objattr['color'];
				}
				$this->SetFColor($bgcol);
				$this->Rect($objattr['BORDER-X'], $objattr['BORDER-Y'], $objattr['BORDER-WIDTH'], $objattr['BORDER-HEIGHT'], 'F');
				$this->SetFColor($this->ConvertColor(255));
				if (isset($objattr['BORDER-WIDTH'])) {
					$this->PaintImgBorder($objattr, $is_table);
				}
				if ($objattr['btype'] == 'EAN13' || $objattr['btype'] == 'ISBN' || $objattr['btype'] == 'ISSN' || $objattr['btype'] == 'UPCA' || $objattr['btype'] == 'UPCE' || $objattr['btype'] == 'EAN8') {
					$this->WriteBarcode($objattr['code'], $objattr['showtext'], $objattr['INNER-X'], $objattr['INNER-Y'], $objattr['bsize'], 0, 0, 0, 0, 0, $objattr['bheight'], $bgcol, $col, $objattr['btype'], $objattr['bsupp'], (isset($objattr['bsupp_code']) ? $objattr['bsupp_code'] : ''), $k);
				}
				// QR-code
				elseif ($objattr['btype'] == 'QR') {
					if (!class_exists('QRcode', false)) {
						include(_MPDF_PATH . 'qrcode/qrcode.class.php');
					}
					$this->qrcode = new QRcode($objattr['code'], $objattr['errorlevel']);
					$this->qrcode->displayFPDF($this, $objattr['INNER-X'], $objattr['INNER-Y'], $objattr['bsize'] * 25, array(255, 255, 255), array(0, 0, 0));
				} else {
					$this->WriteBarcode2($objattr['code'], $objattr['INNER-X'], $objattr['INNER-Y'], $objattr['bsize'], $objattr['bheight'], $bgcol, $col, $objattr['btype'], $objattr['pr_ratio'], $k);
				}
			}
			/* -- END BARCODES -- */

			// TEXT CIRCLE
			if ($objattr['type'] == 'textcircle') {
				$bgcol = '';
				if (isset($objattr['bgcolor']) && $objattr['bgcolor']) {
					$bgcol = $objattr['bgcolor'];
				}
				$col = $this->ConvertColor(0);
				if (isset($objattr['color']) && $objattr['color']) {
					$col = $objattr['color'];
				}
				$this->SetTColor($col);
				$this->SetFColor($bgcol);
				if ($bgcol)
					$this->Rect($objattr['BORDER-X'], $objattr['BORDER-Y'], $objattr['BORDER-WIDTH'], $objattr['BORDER-HEIGHT'], 'F');
				$this->SetFColor($this->ConvertColor(255));
				if (isset($objattr['BORDER-WIDTH'])) {
					$this->PaintImgBorder($objattr, $is_table);
				}
				if (!class_exists('directw', false)) {
					include(_MPDF_PATH . 'classes/directw.php');
				}
				if (empty($this->directw)) {
					$this->directw = new directw($this);
				}
				if (isset($objattr['top-text'])) {
					$this->directw->CircularText($objattr['INNER-X'] + $objattr['INNER-WIDTH'] / 2, $objattr['INNER-Y'] + $objattr['INNER-HEIGHT'] / 2, $objattr['r'] / $k, $objattr['top-text'], 'top', $objattr['fontfamily'], $objattr['fontsize'] / $k, $objattr['fontstyle'], $objattr['space-width'], $objattr['char-width'], (isset($objattr['divider']) ? $objattr['divider'] : ''));
				}
				if (isset($objattr['bottom-text'])) {
					$this->directw->CircularText($objattr['INNER-X'] + $objattr['INNER-WIDTH'] / 2, $objattr['INNER-Y'] + $objattr['INNER-HEIGHT'] / 2, $objattr['r'] / $k, $objattr['bottom-text'], 'bottom', $objattr['fontfamily'], $objattr['fontsize'] / $k, $objattr['fontstyle'], $objattr['space-width'], $objattr['char-width'], (isset($objattr['divider']) ? $objattr['divider'] : ''));
				}
			}

			$this->ResetSpacing();

			// LIST MARKERS (Text or bullets)	// mPDF 6  Lists
			if ($objattr['type'] == 'listmarker') {
				if (isset($objattr['fontfamily'])) {
					$this->SetFont($objattr['fontfamily'], $objattr['fontstyle'], $objattr['fontsizept']);
				}
				$col = $this->ConvertColor(0);
				if (isset($objattr['colorarray']) && ($objattr['colorarray'])) {
					$col = $objattr['colorarray'];
				}

				if (isset($objattr['bullet']) && $objattr['bullet']) { // Used for position "outside" only
					$type = $objattr['bullet'];
					$size = $objattr['size'];

					if ($objattr['listmarkerposition'] == 'inside') {
						$adjx = $size / 2;
						if ($objattr['dir'] == 'rtl') {
							$adjx += $objattr['offset'];
						}
						$this->x += $adjx;
					} else {
						$adjx = $objattr['offset'];
						$adjx += $size / 2;
						if ($objattr['dir'] == 'rtl') {
							$this->x += $adjx;
						} else {
							$this->x -= $adjx;
						}
					}

					$yadj = $objattr['lineBox']['glyphYorigin'];
					if (isset($this->CurrentFont['desc']['XHeight']) && $this->CurrentFont['desc']['XHeight']) {
						$xh = $this->CurrentFont['desc']['XHeight'];
					} else {
						$xh = 500;
					}
					$yadj -= ($this->FontSize * $xh / 1000) * 0.625; // Vertical height of bullet (centre) from baseline= XHeight * 0.625
					$this->y += $yadj;

					$this->_printListBullet($this->x, $this->y, $size, $type, $col);
				} else {
					$this->SetTColor($col);
					$w = $this->GetStringWidth($texto);
					//  NB If change marker-offset, also need to alter in function _getListMarkerWidth
					$adjx = $this->ConvertSize($this->list_marker_offset, $this->FontSize);
					if ($objattr['dir'] == 'rtl') {
						$align = 'L';
						$this->x += $adjx;
					} else {
						// Use these lines to set as marker-offset, right-aligned - default
						$align = 'R';
						$this->x -= $adjx;
						$this->x -= $w;
					}
					$this->Cell($w, $this->FontSize, $texto, 0, 0, $align, 0, '', 0, 0, 0, 'T', 0, false, false, 0, $objattr['lineBox']);
					$this->SetTColor($this->ConvertColor(0));
				}
			}

			// DOT-TAB
			if ($objattr['type'] == 'dottab') {
				if (isset($objattr['fontfamily'])) {
					$this->SetFont($objattr['fontfamily'], '', $objattr['fontsize']);
				}
				$sp = $this->GetStringWidth(' ');
				$nb = floor(($w - 2 * $sp) / $this->GetStringWidth('.'));
				if ($nb > 0) {
					$dots = ' ' . str_repeat('.', $nb) . ' ';
				} else {
					$dots = ' ';
				}
				$col = $this->ConvertColor(0);
				if (isset($objattr['colorarray']) && ($objattr['colorarray'])) {
					$col = $objattr['colorarray'];
				}
				$this->SetTColor($col);
				$save_dh = $this->divheight;
				$save_sbd = $this->spanborddet;
				$save_textvar = $this->textvar; // mPDF 5.7.1
				$this->spanborddet = '';
				$this->divheight = 0;
				$this->textvar = 0x00; // mPDF 5.7.1

				$this->Cell($w, $h, $dots, 0, 0, 'C', 0, '', 0, 0, 0, 'T', 0, false, false, 0, $objattr['lineBox']); // mPDF 6 DOTTAB
				$this->spanborddet = $save_sbd;
				$this->textvar = $save_textvar; // mPDF 5.7.1
				$this->divheight = $save_dh;
				$this->SetTColor($this->ConvertColor(0));
			}

			/* -- FORMS -- */
			// TEXT/PASSWORD INPUT
			if ($objattr['type'] == 'input' && ($objattr['subtype'] == 'TEXT' || $objattr['subtype'] == 'PASSWORD')) {
				$this->mpdfform->print_ob_text($objattr, $w, $h, $texto, $rtlalign, $k, $blockdir);
			}

			// TEXTAREA
			if ($objattr['type'] == 'textarea') {
				$this->mpdfform->print_ob_textarea($objattr, $w, $h, $texto, $rtlalign, $k, $blockdir);
			}

			// SELECT
			if ($objattr['type'] == 'select') {
				$this->mpdfform->print_ob_select($objattr, $w, $h, $texto, $rtlalign, $k, $blockdir);
			}


			// INPUT/BUTTON as IMAGE
			if ($objattr['type'] == 'input' && $objattr['subtype'] == 'IMAGE') {
				$this->mpdfform->print_ob_imageinput($objattr, $w, $h, $texto, $rtlalign, $k, $blockdir);
			}

			// BUTTON
			if ($objattr['type'] == 'input' && ($objattr['subtype'] == 'SUBMIT' || $objattr['subtype'] == 'RESET' || $objattr['subtype'] == 'BUTTON')) {
				$this->mpdfform->print_ob_button($objattr, $w, $h, $texto, $rtlalign, $k, $blockdir);
			}

			// CHECKBOX
			if ($objattr['type'] == 'input' && ($objattr['subtype'] == 'CHECKBOX')) {
				$this->mpdfform->print_ob_checkbox($objattr, $w, $h, $texto, $rtlalign, $k, $blockdir, $x, $y);
			}
			// RADIO
			if ($objattr['type'] == 'input' && ($objattr['subtype'] == 'RADIO')) {
				$this->mpdfform->print_ob_radio($objattr, $w, $h, $texto, $rtlalign, $k, $blockdir, $x, $y);
			}
			/* -- END FORMS -- */
		}
		$this->SetFont($save_currentfontfamily, $save_currentfontstyle, $save_currentfontsize);
		$this->y = $save_y;
		$this->x = $save_x;
		unset($content);
	}

	function _printListBullet($x, $y, $size, $type, $color)
	{
		// x and y are the centre of the bullet; size is the width and/or height in mm
		$fcol = $this->SetTColor($color, true);
		$lcol = strtoupper($fcol); // change 0 0 0 rg to 0 0 0 RG
		$this->_out(sprintf('q %s %s', $lcol, $fcol));
		$this->_out('0 j 0 J [] 0 d');
		if ($type == 'square') {
			$size *= 0.85; // Smaller to appear the same size as circle/disc
			$this->_out(sprintf('%.3F %.3F %.3F %.3F re f', ($x - $size / 2) * _MPDFK, ($this->h - $y + $size / 2) * _MPDFK, ($size) * _MPDFK, (-$size) * _MPDFK));
		} elseif ($type == 'disc') {
			$this->Circle($x, $y, $size / 2, 'F'); // Fill
		} elseif ($type == 'circle') {
			$lw = $size / 12; // Line width
			$this->_out(sprintf('%.3F w ', $lw * _MPDFK));
			$this->Circle($x, $y, $size / 2 - $lw / 2, 'S'); // Stroke
		}
		$this->_out('Q');
	}

	// mPDF 6
	// Get previous character and move pointers
	function _moveToPrevChar(&$contentctr, &$charctr, $content)
	{
		$lastchar = false;
		$charctr--;
		while ($charctr < 0) { // go back to previous $content[]
			$contentctr--;
			if ($contentctr < 0) {
				return false;
			}
			if ($this->usingCoreFont) {
				$charctr = strlen($content[$contentctr]) - 1;
			} else {
				$charctr = mb_strlen($content[$contentctr], $this->mb_enc) - 1;
			}
		}
		if ($this->usingCoreFont) {
			$lastchar = $content[$contentctr][$charctr];
		} else {
			$lastchar = mb_substr($content[$contentctr], $charctr, 1, $this->mb_enc);
		}
		return $lastchar;
	}

	// Get previous character
	function _getPrevChar($contentctr, $charctr, $content)
	{
		$lastchar = false;
		$charctr--;
		while ($charctr < 0) { // go back to previous $content[]
			$contentctr--;
			if ($contentctr < 0) {
				return false;
			}
			if ($this->usingCoreFont) {
				$charctr = strlen($content[$contentctr]) - 1;
			} else {
				$charctr = mb_strlen($content[$contentctr], $this->mb_enc) - 1;
			}
		}
		if ($this->usingCoreFont) {
			$lastchar = $content[$contentctr][$charctr];
		} else {
			$lastchar = mb_substr($content[$contentctr], $charctr, 1, $this->mb_enc);
		}
		return $lastchar;
	}

	function WriteFlowingBlock($s, $sOTLdata)
	{ // mPDF 5.7.1
		$currentx = $this->x;
		$is_table = $this->flowingBlockAttr['is_table'];
		$table_draft = $this->flowingBlockAttr['table_draft'];
		// width of all the content so far in points
		$contentWidth = & $this->flowingBlockAttr['contentWidth'];
		// cell width in points
		$maxWidth = & $this->flowingBlockAttr['width'];
		$lineCount = & $this->flowingBlockAttr['lineCount'];
		// line height in user units
		$stackHeight = & $this->flowingBlockAttr['height'];
		$align = & $this->flowingBlockAttr['align'];
		$content = & $this->flowingBlockAttr['content'];
		$contentB = & $this->flowingBlockAttr['contentB'];
		$font = & $this->flowingBlockAttr['font'];
		$valign = & $this->flowingBlockAttr['valign'];
		$blockstate = $this->flowingBlockAttr['blockstate'];
		$cOTLdata = & $this->flowingBlockAttr['cOTLdata']; // mPDF 5.7.1

		$newblock = $this->flowingBlockAttr['newblock'];
		$blockdir = $this->flowingBlockAttr['blockdir'];

		// *********** BLOCK BACKGROUND COLOR ***************** //
		if ($this->blk[$this->blklvl]['bgcolor'] && !$is_table) {
			$fill = 0;
		} else {
			$this->SetFColor($this->ConvertColor(255));
			$fill = 0;
		}
		$font[] = $this->saveFont();
		$content[] = '';
		$contentB[] = '';
		$cOTLdata[] = $sOTLdata; // mPDF 5.7.1
		$currContent = & $content[count($content) - 1];

		$CJKoverflow = false;
		$Oikomi = false; // mPDF 6
		$hanger = '';

		// COLS
		$oldcolumn = $this->CurrCol;
		if ($this->ColActive && !$is_table) {
			$this->breakpoints[$this->CurrCol][] = $this->y;
		} // *COLUMNS*

		/* -- TABLES -- */
		if ($is_table) {
			$ipaddingL = 0;
			$ipaddingR = 0;
			$paddingL = 0;
			$paddingR = 0;
			$cpaddingadjustL = 0;
			$cpaddingadjustR = 0;
			// Added mPDF 3.0
			$fpaddingR = 0;
			$fpaddingL = 0;
		} else {
			/* -- END TABLES -- */
			$ipaddingL = $this->blk[$this->blklvl]['padding_left'];
			$ipaddingR = $this->blk[$this->blklvl]['padding_right'];
			$paddingL = ($ipaddingL * _MPDFK);
			$paddingR = ($ipaddingR * _MPDFK);
			$this->cMarginL = $this->blk[$this->blklvl]['border_left']['w'];
			$cpaddingadjustL = -$this->cMarginL;
			$this->cMarginR = $this->blk[$this->blklvl]['border_right']['w'];
			$cpaddingadjustR = -$this->cMarginR;
			// Added mPDF 3.0 Float DIV
			$fpaddingR = 0;
			$fpaddingL = 0;
			/* -- CSS-FLOAT -- */
			if (count($this->floatDivs)) {
				list($l_exists, $r_exists, $l_max, $r_max, $l_width, $r_width) = $this->GetFloatDivInfo($this->blklvl);
				if ($r_exists) {
					$fpaddingR = $r_width;
				}
				if ($l_exists) {
					$fpaddingL = $l_width;
				}
			}
			/* -- END CSS-FLOAT -- */

			$usey = $this->y + 0.002;
			if (($newblock) && ($blockstate == 1 || $blockstate == 3) && ($lineCount == 0)) {
				$usey += $this->blk[$this->blklvl]['margin_top'] + $this->blk[$this->blklvl]['padding_top'] + $this->blk[$this->blklvl]['border_top']['w'];
			}
			/* -- CSS-IMAGE-FLOAT -- */
			// If float exists at this level
			if (isset($this->floatmargins['R']) && $usey <= $this->floatmargins['R']['y1'] && $usey >= $this->floatmargins['R']['y0'] && !$this->floatmargins['R']['skipline']) {
				$fpaddingR += $this->floatmargins['R']['w'];
			}
			if (isset($this->floatmargins['L']) && $usey <= $this->floatmargins['L']['y1'] && $usey >= $this->floatmargins['L']['y0'] && !$this->floatmargins['L']['skipline']) {
				$fpaddingL += $this->floatmargins['L']['w'];
			}
			/* -- END CSS-IMAGE-FLOAT -- */
		} // *TABLES*
		//OBJECTS - IMAGES & FORM Elements (NB has already skipped line/page if required - in printbuffer)
		if (substr($s, 0, 3) == "\xbb\xa4\xac") { //identifier has been identified!
			$objattr = $this->_getObjAttr($s);
			$h_corr = 0;
			if ($is_table) { // *TABLES*
				$maximumW = ($maxWidth / _MPDFK) - ($this->cellPaddingL + $this->cMarginL + $this->cellPaddingR + $this->cMarginR);  // *TABLES*
			} // *TABLES*
			else { // *TABLES*
				if (($newblock) && ($blockstate == 1 || $blockstate == 3) && ($lineCount == 0) && (!$is_table)) {
					$h_corr = $this->blk[$this->blklvl]['padding_top'] + $this->blk[$this->blklvl]['border_top']['w'];
				}
				$maximumW = ($maxWidth / _MPDFK) - ($this->blk[$this->blklvl]['padding_left'] + $this->blk[$this->blklvl]['border_left']['w'] + $this->blk[$this->blklvl]['padding_right'] + $this->blk[$this->blklvl]['border_right']['w'] + $fpaddingL + $fpaddingR );
			} // *TABLES*
			$objattr = $this->inlineObject($objattr['type'], $this->lMargin + $fpaddingL + ($contentWidth / _MPDFK), ($this->y + $h_corr), $objattr, $this->lMargin, ($contentWidth / _MPDFK), $maximumW, $stackHeight, true, $is_table);

			// SET LINEHEIGHT for this line ================ RESET AT END
			$stackHeight = MAX($stackHeight, $objattr['OUTER-HEIGHT']);
			$this->objectbuffer[count($content) - 1] = $objattr;
			// if (isset($objattr['vertical-align'])) { $valign = $objattr['vertical-align']; }
			// else { $valign = ''; }
			// LIST MARKERS	// mPDF 6  Lists
			if ($objattr['type'] == 'image' && isset($objattr['listmarker']) && $objattr['listmarker'] && $objattr['listmarkerposition'] == 'outside') {
				// do nothing
			} else {
				$contentWidth += ($objattr['OUTER-WIDTH'] * _MPDFK);
			}
			return;
		}

		$lbw = $rbw = 0; // Border widths
		if (!empty($this->spanborddet)) {
			if (isset($this->spanborddet['L']))
				$lbw = $this->spanborddet['L']['w'];
			if (isset($this->spanborddet['R']))
				$rbw = $this->spanborddet['R']['w'];
		}

		if ($this->usingCoreFont) {
			$clen = strlen($s);
		} else {
			$clen = mb_strlen($s, $this->mb_enc);
		}

		// for every character in the string
		for ($i = 0; $i < $clen; $i++) {

			// extract the current character
			// get the width of the character in points
			if ($this->usingCoreFont) {
				$c = $s[$i];
				// Soft Hyphens chr(173)
				$cw = ($this->GetCharWidthCore($c) * _MPDFK);
				if (($this->textvar & FC_KERNING) && $i > 0) { // mPDF 5.7.1
					if (isset($this->CurrentFont['kerninfo'][$s[($i - 1)]][$c])) {
						$cw += ($this->CurrentFont['kerninfo'][$s[($i - 1)]][$c] * $this->FontSizePt / 1000 );
					}
				}
			} else {
				$c = mb_substr($s, $i, 1, $this->mb_enc);
				$cw = ($this->GetCharWidthNonCore($c, false) * _MPDFK);
				// mPDF 5.7.1
				// Use OTL GPOS
				if (isset($this->CurrentFont['useOTL']) && ($this->CurrentFont['useOTL'] & 0xFF)) {
					// ...WriteFlowingBlock...
					// Only  add XAdvanceL (not sure at present whether RTL or LTR writing direction)
					// At this point, XAdvanceL and XAdvanceR will balance
					if (isset($sOTLdata['GPOSinfo'][$i]['XAdvanceL'])) {
						$cw += $sOTLdata['GPOSinfo'][$i]['XAdvanceL'] * (1000 / $this->CurrentFont['unitsPerEm']) * ($this->FontSize / 1000) * _MPDFK;
					}
				}
				if (($this->textvar & FC_KERNING) && $i > 0) { // mPDF 5.7.1
					$lastc = mb_substr($s, ($i - 1), 1, $this->mb_enc);
					$ulastc = $this->UTF8StringToArray($lastc, false);
					$uc = $this->UTF8StringToArray($c, false);
					if (isset($this->CurrentFont['kerninfo'][$ulastc[0]][$uc[0]])) {
						$cw += ($this->CurrentFont['kerninfo'][$ulastc[0]][$uc[0]] * $this->FontSizePt / 1000 );
					}
				}
			}

			if ($i == 0) {
				$cw += $lbw * _MPDFK;
				$contentB[(count($contentB) - 1)] .= 'L';
			}
			if ($i == ($clen - 1)) {
				$cw += $rbw * _MPDFK;
				$contentB[(count($contentB) - 1)] .= 'R';
			}
			if ($c == ' ') {
				$currContent .= $c;
				$contentWidth += $cw;
				continue;
			}

			// Paragraph INDENT
			$WidthCorrection = 0;
			if (($newblock) && ($blockstate == 1 || $blockstate == 3) && isset($this->blk[$this->blklvl]['text_indent']) && ($lineCount == 0) && (!$is_table) && ($align != 'C')) {
				$ti = $this->ConvertSize($this->blk[$this->blklvl]['text_indent'], $this->blk[$this->blklvl]['inner_width'], $this->blk[$this->blklvl]['InlineProperties']['size'], false);  // mPDF 5.7.4
				$WidthCorrection = ($ti * _MPDFK);
			}
			// OUTDENT
			foreach ($this->objectbuffer AS $k => $objattr) {   // mPDF 6 DOTTAB
				if ($objattr['type'] == 'dottab') {
					$WidthCorrection -= ($objattr['outdent'] * _MPDFK);
					break;
				}
			}


			// Added mPDF 3.0 Float DIV
			$fpaddingR = 0;
			$fpaddingL = 0;
			/* -- CSS-FLOAT -- */
			if (count($this->floatDivs)) {
				list($l_exists, $r_exists, $l_max, $r_max, $l_width, $r_width) = $this->GetFloatDivInfo($this->blklvl);
				if ($r_exists) {
					$fpaddingR = $r_width;
				}
				if ($l_exists) {
					$fpaddingL = $l_width;
				}
			}
			/* -- END CSS-FLOAT -- */

			$usey = $this->y + 0.002;
			if (($newblock) && ($blockstate == 1 || $blockstate == 3) && ($lineCount == 0)) {
				$usey += $this->blk[$this->blklvl]['margin_top'] + $this->blk[$this->blklvl]['padding_top'] + $this->blk[$this->blklvl]['border_top']['w'];
			}

			/* -- CSS-IMAGE-FLOAT -- */
			// If float exists at this level
			if (isset($this->floatmargins['R']) && $usey <= $this->floatmargins['R']['y1'] && $usey >= $this->floatmargins['R']['y0'] && !$this->floatmargins['R']['skipline']) {
				$fpaddingR += $this->floatmargins['R']['w'];
			}
			if (isset($this->floatmargins['L']) && $usey <= $this->floatmargins['L']['y1'] && $usey >= $this->floatmargins['L']['y0'] && !$this->floatmargins['L']['skipline']) {
				$fpaddingL += $this->floatmargins['L']['w'];
			}
			/* -- END CSS-IMAGE-FLOAT -- */


			// try adding another char
			if (( $contentWidth + $cw > $maxWidth - $WidthCorrection - (($this->cMarginL + $this->cMarginR) * _MPDFK) - ($paddingL + $paddingR + (($fpaddingL + $fpaddingR) * _MPDFK) ) + 0.001)) {// 0.001 is to correct for deviations converting mm=>pts
				// it won't fit, output what we already have
				$lineCount++;

				// contains any content that didn't make it into this print
				$savedContent = '';
				$savedContentB = '';
				$savedOTLdata = array(); // mPDF 5.7.1
				$savedFont = array();
				$savedObj = array();
				$savedPreOTLdata = array(); // mPDF 5.7.1
				$savedPreContent = array();
				$savedPreContentB = array();
				$savedPreFont = array();

				// mPDF 6
				// New line-breaking algorithm
				/////////////////////
				// LINE BREAKING
				/////////////////////
				$breakfound = false;
				$contentctr = count($content) - 1;
				if ($this->usingCoreFont) {
					$charctr = strlen($currContent);
				} else {
					$charctr = mb_strlen($currContent, $this->mb_enc);
				}
				$checkchar = $c;
				$prevchar = $this->_getPrevChar($contentctr, $charctr, $content);

				/* -- CJK-FONTS -- */
				/////////////////////
				// 1) CJK Overflowing a) punctuation or b) Oikomi
				/////////////////////
				// Next character ($c) is suitable to add as overhanging or squeezed punctuation, or Oikomi
				if ($CJKoverflow || $Oikomi) { // If flag already set
					$CJKoverflow = false;
					$Oikomi = false;
					$breakfound = true;
				}
				if (!$this->usingCoreFont && !$breakfound && $this->checkCJK) {
					// Get next/following character (in this chunk)
					$followingchar = '';
					if ($i < ($clen - 1)) {
						if ($this->usingCoreFont) {
							$followingchar = $s[$i + 1];
						} else {
							$followingchar = mb_substr($s, $i + 1, 1, $this->mb_enc);
						}
					}
					/////////////////////
					// 1a) Overflow punctuation
					/////////////////////
					if (preg_match("/[" . $this->pregCJKchars . "]/u", $prevchar) && preg_match("/[" . $this->CJKoverflow . "]/u", $checkchar) && $this->allowCJKorphans) {
						// add character onto this line
						$currContent .= $c;
						$contentWidth += $cw;
						$CJKoverflow = true; // Set flag
						continue;
					}
					/////////////////////
					// 1b) Try squeezing another character(s) onto this line = Oikomi, if character cannot end line
					//  or next character cannot start line (and not splitting CJK numerals)
					/////////////////////
					// NB otherwise it move lastchar(s) to next line to keep $c company = Oidashi, which is done below in standard way
					elseif (preg_match("/[" . $this->pregCJKchars . "]/u", $checkchar) && $this->allowCJKorphans &&
						(preg_match("/[" . $this->CJKleading . "]/u", $followingchar) || preg_match("/[" . $this->CJKfollowing . "]/u", $checkchar)) &&
						!preg_match("/[" . $this->CJKleading . "]/u", $checkchar) && !preg_match("/[" . $this->CJKfollowing . "]/u", $followingchar) &&
						!(preg_match("/[0-9\x{ff10}-\x{ff19}]/u", $followingchar) && preg_match("/[0-9\x{ff10}-\x{ff19}]/u", $checkchar))) {
						// add character onto this line
						$currContent .= $c;
						$contentWidth += $cw;
						$Oikomi = true; // Set flag
						continue;
					}
				}
				/* -- END CJK-FONTS -- */
				/* -- HYPHENATION -- */
				/////////////////////
				// AUTOMATIC HYPHENATION
				// 2) Automatic hyphen in current word (does not cross tags)
				/////////////////////
				if (isset($this->textparam['hyphens']) && $this->textparam['hyphens'] == 1) {
					$currWord = '';
					// Look back and ahead to get current word
					for ($ac = $charctr - 1; $ac >= 0; $ac--) {
						if ($this->usingCoreFont) {
							$addc = substr($currContent, $ac, 1);
						} else {
							$addc = mb_substr($currContent, $ac, 1, $this->mb_enc);
						}
						if ($addc == ' ') {
							break;
						}
						$currWord = $addc . $currWord;
					}
					$start = $ac + 1;
					for ($ac = $i; $ac < ($clen - 1); $ac++) {
						if ($this->usingCoreFont) {
							$addc = substr($s, $ac, 1);
						} else {
							$addc = mb_substr($s, $ac, 1, $this->mb_enc);
						}
						if ($addc == ' ') {
							break;
						}
						$currWord .= $addc;
					}
					$ptr = $this->hyphenateWord($currWord, $charctr - $start);
					if ($ptr > -1) {
						$breakfound = array($contentctr, $start + $ptr, $contentctr, $start + $ptr, 'hyphen');
					}
				}
				/* -- END HYPHENATION -- */

				// Search backwards to find first line-break opportunity
				while ($breakfound == false && $prevchar !== false) {
					$cutcontentctr = $contentctr;
					$cutcharctr = $charctr;
					$prevchar = $this->_moveToPrevChar($contentctr, $charctr, $content);
					/////////////////////
					// 3) Break at SPACE
					/////////////////////
					if ($prevchar == ' ') {
						$breakfound = array($contentctr, $charctr, $cutcontentctr, $cutcharctr, 'discard');
					}
					/////////////////////
					// 4) Break at U+200B in current word (Khmer, Lao & Thai Invisible word boundary, and Tibetan)
					/////////////////////
					elseif ($prevchar == "\xe2\x80\x8b") { // U+200B Zero-width Word Break
						$breakfound = array($contentctr, $charctr, $cutcontentctr, $cutcharctr, 'discard');
					}
					/////////////////////
					// 5) Break at Hard HYPHEN '-' or U+2010
					/////////////////////
					elseif (isset($this->textparam['hyphens']) && $this->textparam['hyphens'] != 2 && ($prevchar == '-' || $prevchar == "\xe2\x80\x90")) {
						// Don't break a URL
						// Look back to get first part of current word
						$checkw = '';
						for ($ac = $charctr - 1; $ac >= 0; $ac--) {
							if ($this->usingCoreFont) {
								$addc = substr($currContent, $ac, 1);
							} else {
								$addc = mb_substr($currContent, $ac, 1, $this->mb_enc);
							}
							if ($addc == ' ') {
								break;
							}
							$checkw = $addc . $checkw;
						}
						// Don't break if HyphenMinus AND (a URL or before a numeral or before a >)
						if ((!preg_match('/(http:|ftp:|https:|www\.)/', $checkw) && $checkchar != '>' && !preg_match('/[0-9]/', $checkchar)) || $prevchar == "\xe2\x80\x90") {
							$breakfound = array($cutcontentctr, $cutcharctr, $cutcontentctr, $cutcharctr, 'cut');
						}
					}
					/////////////////////
					// 6) Break at Soft HYPHEN (replace with hard hyphen)
					/////////////////////
					elseif (isset($this->textparam['hyphens']) && $this->textparam['hyphens'] != 2 && !$this->usingCoreFont && $prevchar == "\xc2\xad") {
						$breakfound = array($cutcontentctr, $cutcharctr, $cutcontentctr, $cutcharctr, 'cut');
						$content[$contentctr] = mb_substr($content[$contentctr], 0, $charctr, $this->mb_enc) . '-' . mb_substr($content[$contentctr], $charctr + 1, mb_strlen($content[$contentctr]), $this->mb_enc);
						if (!empty($cOTLdata[$contentctr])) {
							$cOTLdata[$contentctr]['char_data'][$charctr] = array('bidi_class' => 9, 'uni' => 45);
							$cOTLdata[$contentctr]['group'][$charctr] = 'C';
						}
					} elseif (isset($this->textparam['hyphens']) && $this->textparam['hyphens'] != 2 && $this->FontFamily != 'csymbol' && $this->FontFamily != 'czapfdingbats' && $prevchar == chr(173)) {
						$breakfound = array($cutcontentctr, $cutcharctr, $cutcontentctr, $cutcharctr, 'cut');
						$content[$contentctr] = substr($content[$contentctr], 0, $charctr) . '-' . substr($content[$contentctr], $charctr + 1);
					}
					/* -- CJK-FONTS -- */
					/////////////////////
					// 7) Break at CJK characters (unless forbidden characters to end or start line)
					// CJK Avoiding line break in the middle of numerals
					/////////////////////
					elseif (!$this->usingCoreFont && $this->checkCJK && preg_match("/[" . $this->pregCJKchars . "]/u", $checkchar) &&
						!preg_match("/[" . $this->CJKfollowing . "]/u", $checkchar) && !preg_match("/[" . $this->CJKleading . "]/u", $prevchar) &&
						!(preg_match("/[0-9\x{ff10}-\x{ff19}]/u", $prevchar) && preg_match("/[0-9\x{ff10}-\x{ff19}]/u", $checkchar))) {
						$breakfound = array($cutcontentctr, $cutcharctr, $cutcontentctr, $cutcharctr, 'cut');
					}
					/* -- END CJK-FONTS -- */
					/////////////////////
					// 8) Break at OBJECT (Break before all objects here - selected objects are moved forward to next line below e.g. dottab)
					/////////////////////
					if (isset($this->objectbuffer[$contentctr])) {
						$breakfound = array($cutcontentctr, $cutcharctr, $cutcontentctr, $cutcharctr, 'cut');
					}


					$checkchar = $prevchar;
				}

				// If a line-break opportunity found:
				if (is_array($breakfound)) {
					$contentctr = $breakfound[0];
					$charctr = $breakfound[1];
					$cutcontentctr = $breakfound[2];
					$cutcharctr = $breakfound[3];
					$type = $breakfound[4];
					// Cache chunks which are already processed, but now need to be passed on to the new line
					for ($ix = count($content) - 1; $ix > $cutcontentctr; $ix--) {
						// save and crop off any subsequent chunks
						/* -- OTL -- */
						if (!empty($sOTLdata)) {
							$tmpOTL = array_pop($cOTLdata);
							$savedPreOTLdata[] = $tmpOTL;
						}
						/* -- END OTL -- */
						$savedPreContent[] = array_pop($content);
						$savedPreContentB[] = array_pop($contentB);
						$savedPreFont[] = array_pop($font);
					}

					// Next cache the part which will start the next line
					if ($this->usingCoreFont) {
						$savedPreContent[] = substr($content[$cutcontentctr], $cutcharctr);
					} else {
						$savedPreContent[] = mb_substr($content[$cutcontentctr], $cutcharctr, mb_strlen($content[$cutcontentctr]), $this->mb_enc);
					}
					$savedPreContentB[] = preg_replace('/L/', '', $contentB[$cutcontentctr]);
					$savedPreFont[] = $font[$cutcontentctr];
					/* -- OTL -- */
					if (!empty($sOTLdata)) {
						$savedPreOTLdata[] = $this->otl->splitOTLdata($cOTLdata[$cutcontentctr], $cutcharctr, $cutcharctr);
					}
					/* -- END OTL -- */


					// Finally adjust the Current content which ends this line
					if ($cutcharctr == 0 && $type == 'discard') {
						array_pop($content);
						array_pop($contentB);
						array_pop($font);
						array_pop($cOTLdata);
					}

					$currContent = & $content[count($content) - 1];
					if ($this->usingCoreFont) {
						$currContent = substr($currContent, 0, $charctr);
					} else {
						$currContent = mb_substr($currContent, 0, $charctr, $this->mb_enc);
					}

					if (!empty($sOTLdata)) {
						$savedPreOTLdata[] = $this->otl->splitOTLdata($cOTLdata[(count($cOTLdata) - 1)], mb_strlen($currContent, $this->mb_enc));
					}

					if (strpos($contentB[(count($contentB) - 1)], 'R') !== false) {   // ???
						$contentB[count($content) - 1] = preg_replace('/R/', '', $contentB[count($content) - 1]); // ???
					}

					if ($type == 'hyphen') {
						$currContent .= '-';
						if (!empty($cOTLdata[(count($cOTLdata) - 1)])) {
							$cOTLdata[(count($cOTLdata) - 1)]['char_data'][] = array('bidi_class' => 9, 'uni' => 45);
							$cOTLdata[(count($cOTLdata) - 1)]['group'] .= 'C';
						}
					}

					$savedContent = '';
					$savedContentB = '';
					$savedFont = array();
					$savedOTLdata = array();
				}
				// If no line-break opportunity found - split at current position
				// or - Next character ($c) is suitable to add as overhanging or squeezed punctuation, or Oikomi, as set above by:
				// 1) CJK Overflowing a) punctuation or b) Oikomi
				// in which case $breakfound==1 and NOT array

				if (!is_array($breakfound)) {
					$savedFont = $this->saveFont();
					if (!empty($sOTLdata)) {
						$savedOTLdata = $this->otl->splitOTLdata($cOTLdata[(count($cOTLdata) - 1)], mb_strlen($currContent, $this->mb_enc));
					}
				}

				if ($content[count($content) - 1] == '' && !isset($this->objectbuffer[count($content) - 1])) {
					array_pop($content);
					array_pop($contentB);
					array_pop($font);
					array_pop($cOTLdata);
					$currContent = & $content[count($content) - 1];
				}

				// Right Trim current content - including CJK space, and for OTLdata
				// incl. CJK - strip CJK space at end of line &#x3000; = \xe3\x80\x80 = CJK space
				$currContent = rtrim($currContent);
				if ($this->checkCJK) {
					$currContent = preg_replace("/\xe3\x80\x80$/", '', $currContent);
				} // *CJK-FONTS*
				/* -- OTL -- */
				if (isset($this->CurrentFont['useOTL']) && $this->CurrentFont['useOTL']) {
					$this->otl->trimOTLdata($cOTLdata[count($cOTLdata) - 1], false, true); // NB also does U+3000
				}
				/* -- END OTL -- */


				// Selected OBJECTS are moved forward to next line, unless they come before a space or U+200B (type='discard')
				if (isset($this->objectbuffer[(count($content) - 1)]) && (!isset($type) || $type != 'discard')) {
					$objtype = $this->objectbuffer[(count($content) - 1)]['type'];
					if ($objtype == 'dottab' || $objtype == 'bookmark' || $objtype == 'indexentry' || $objtype == 'toc' || $objtype == 'annot') {
						$savedObj = array_pop($this->objectbuffer);
					}
				}


				// Decimal alignment (cancel if wraps to > 1 line)
				if ($is_table && substr($align, 0, 1) == 'D') {
					$align = substr($align, 2, 1);
				}

				$lineBox = array();

				$this->_setInlineBlockHeights($lineBox, $stackHeight, $content, $font, $is_table);

				// update $contentWidth since it has changed with cropping
				$contentWidth = 0;

				$inclCursive = false;
				foreach ($content as $k => $chunk) {
					if (isset($this->objectbuffer[$k]) && $this->objectbuffer[$k]) {
						// LIST MARKERS
						if ($this->objectbuffer[$k]['type'] == 'image' && isset($this->objectbuffer[$k]['listmarker']) && $this->objectbuffer[$k]['listmarker']) {
							if ($this->objectbuffer[$k]['listmarkerposition'] != 'outside') {
								$contentWidth += $this->objectbuffer[$k]['OUTER-WIDTH'] * _MPDFK;
							}
						} else {
							$contentWidth += $this->objectbuffer[$k]['OUTER-WIDTH'] * _MPDFK;
						}
					} elseif (!isset($this->objectbuffer[$k]) || (isset($this->objectbuffer[$k]) && !$this->objectbuffer[$k])) {
						$this->restoreFont($font[$k], false);
						if ($this->checkCJK && $k == count($content) - 1 && $CJKoverflow && $align == 'J' && $this->allowCJKoverflow && $this->CJKforceend) {
							// force-end overhang
							$hanger = mb_substr($chunk, mb_strlen($chunk, $this->mb_enc) - 1, 1, $this->mb_enc);
							// Probably ought to do something with char_data and GPOS in cOTLdata...
							$content[$k] = $chunk = mb_substr($chunk, 0, mb_strlen($chunk, $this->mb_enc) - 1, $this->mb_enc);
						}

						// Soft Hyphens chr(173) + Replace NBSP with SPACE + Set inclcursive if includes CURSIVE TEXT
						if (!$this->usingCoreFont) {
							/* -- OTL -- */
							if ((isset($this->CurrentFont['useOTL']) && $this->CurrentFont['useOTL']) || !empty($sOTLdata)) {
								$this->otl->removeChar($chunk, $cOTLdata[$k], "\xc2\xad");
								$this->otl->replaceSpace($chunk, $cOTLdata[$k]); // NBSP -> space
								if (preg_match("/([" . $this->pregCURSchars . "])/u", $chunk)) {
									$inclCursive = true;
								}
								$content[$k] = $chunk;
							}
							/* -- END OTL -- */ else {  // *OTL*
								$content[$k] = $chunk = str_replace("\xc2\xad", '', $chunk);
								$content[$k] = $chunk = str_replace(chr(194) . chr(160), chr(32), $chunk);
							} // *OTL*
						} elseif ($this->FontFamily != 'csymbol' && $this->FontFamily != 'czapfdingbats') {
							$content[$k] = $chunk = str_replace(chr(173), '', $chunk);
							$content[$k] = $chunk = str_replace(chr(160), chr(32), $chunk);
						}

						$contentWidth += $this->GetStringWidth($chunk, true, (isset($cOTLdata[$k]) ? $cOTLdata[$k] : false), $this->textvar) * _MPDFK;  // mPDF 5.7.1
						if (!empty($this->spanborddet)) {
							if (isset($this->spanborddet['L']['w']) && strpos($contentB[$k], 'L') !== false)
								$contentWidth += $this->spanborddet['L']['w'] * _MPDFK;
							if (isset($this->spanborddet['R']['w']) && strpos($contentB[$k], 'R') !== false)
								$contentWidth += $this->spanborddet['R']['w'] * _MPDFK;
						}
					}
				}

				$lastfontreqstyle = (isset($font[count($font) - 1]['ReqFontStyle']) ? $font[count($font) - 1]['ReqFontStyle'] : '');
				$lastfontstyle = (isset($font[count($font) - 1]['style']) ? $font[count($font) - 1]['style'] : '');
				if ($blockdir == 'ltr' && strpos($lastfontreqstyle, "I") !== false && strpos($lastfontstyle, "I") === false) { // Artificial italic
					$lastitalic = $this->FontSize * 0.15 * _MPDFK;
				} else {
					$lastitalic = 0;
				}




				// NOW FORMAT THE LINE TO OUTPUT
				if (!$table_draft) {
					// DIRECTIONALITY RTL
					$chunkorder = range(0, count($content) - 1); // mPDF 5.7
					/* -- OTL -- */
					// mPDF 6
					if ($blockdir == 'rtl' || $this->biDirectional) {
						$this->otl->_bidiReorder($chunkorder, $content, $cOTLdata, $blockdir);
						// From this point on, $content and $cOTLdata may contain more elements (and re-ordered) compared to
						// $this->objectbuffer and $font ($chunkorder contains the mapping)
					}

					/* -- END OTL -- */
					// Remove any XAdvance from OTL data at end of line
					foreach ($chunkorder AS $aord => $k) {
						if (count($cOTLdata)) {
							$this->restoreFont($font[$k], false);
							// ...WriteFlowingBlock...
							if ($aord == count($chunkorder) - 1 && isset($cOTLdata[$aord]['group'])) { // Last chunk on line
								$nGPOS = strlen($cOTLdata[$aord]['group']) - 1; // Last character
								if (isset($cOTLdata[$aord]['GPOSinfo'][$nGPOS]['XAdvanceL']) || isset($cOTLdata[$aord]['GPOSinfo'][$nGPOS]['XAdvanceR'])) {
									if (isset($cOTLdata[$aord]['GPOSinfo'][$nGPOS]['XAdvanceL'])) {
										$w = $cOTLdata[$aord]['GPOSinfo'][$nGPOS]['XAdvanceL'] * 1000 / $this->CurrentFont['unitsPerEm'];
									} else {
										$w = $cOTLdata[$aord]['GPOSinfo'][$nGPOS]['XAdvanceR'] * 1000 / $this->CurrentFont['unitsPerEm'];
									}
									$w *= ($this->FontSize / 1000);
									$contentWidth -= $w * _MPDFK;
									$cOTLdata[$aord]['GPOSinfo'][$nGPOS]['XAdvanceL'] = 0;
									$cOTLdata[$aord]['GPOSinfo'][$nGPOS]['XAdvanceR'] = 0;
								}

								// If last character has an XPlacement set, adjust width calculation, and add to XAdvance to account for it
								if (isset($cOTLdata[$aord]['GPOSinfo'][$nGPOS]['XPlacement'])) {
									$w = -$cOTLdata[$aord]['GPOSinfo'][$nGPOS]['XPlacement'] * 1000 / $this->CurrentFont['unitsPerEm'];
									$w *= ($this->FontSize / 1000);
									$contentWidth -= $w * _MPDFK;
									$cOTLdata[$aord]['GPOSinfo'][$nGPOS]['XAdvanceL'] = $cOTLdata[$aord]['GPOSinfo'][$nGPOS]['XPlacement'];
									$cOTLdata[$aord]['GPOSinfo'][$nGPOS]['XAdvanceR'] = $cOTLdata[$aord]['GPOSinfo'][$nGPOS]['XPlacement'];
								}
							}
						}
					}

					// JUSTIFICATION J
					$jcharspacing = 0;
					$jws = 0;
					$nb_carac = 0;
					$nb_spaces = 0;
					$jkashida = 0;
					// if it's justified, we need to find the char/word spacing (or if hanger $this->CJKforceend)
					if (($align == 'J' && !$CJKoverflow) || (($contentWidth + $lastitalic > $maxWidth - $WidthCorrection - (($this->cMarginL + $this->cMarginR) * _MPDFK) - ($paddingL + $paddingR + (($fpaddingL + $fpaddingR) * _MPDFK) ) + 0.001) && (!$CJKoverflow || ($CJKoverflow && !$this->allowCJKoverflow))) || $CJKoverflow && $align == 'J' && $this->allowCJKoverflow && $hanger && $this->CJKforceend) {   // 0.001 is to correct for deviations converting mm=>pts
						// JUSTIFY J (Use character spacing)
						// WORD SPACING
						foreach ($chunkorder AS $aord => $k) { // mPDF 5.7
							$chunk = $content[$aord];
							if (!isset($this->objectbuffer[$k]) || (isset($this->objectbuffer[$k]) && !$this->objectbuffer[$k])) {
								$nb_carac += mb_strlen($chunk, $this->mb_enc);
								$nb_spaces += mb_substr_count($chunk, ' ', $this->mb_enc);
								// Use GPOS OTL
								if (isset($this->CurrentFont['useOTL']) && ($this->CurrentFont['useOTL'] & 0xFF)) {
									if (isset($cOTLdata[$aord]['group']) && $cOTLdata[$aord]['group']) {
										$nb_carac -= substr_count($cOTLdata[$aord]['group'], 'M');
									}
								}
							} else {
								$nb_carac ++;
							} // mPDF 6 allow spacing for inline object
						}
						// GetJSpacing adds kashida spacing to GPOSinfo if appropriate for Font
						list($jcharspacing, $jws, $jkashida) = $this->GetJspacing($nb_carac, $nb_spaces, ($maxWidth - $lastitalic - $contentWidth - $WidthCorrection - (($this->cMarginL + $this->cMarginR) * _MPDFK) - ($paddingL + $paddingR + (($fpaddingL + $fpaddingR) * _MPDFK) )), $inclCursive, $cOTLdata);
					}

					// WORD SPACING
					$empty = $maxWidth - $lastitalic - $WidthCorrection - $contentWidth - (($this->cMarginL + $this->cMarginR) * _MPDFK) - ($paddingL + $paddingR + (($fpaddingL + $fpaddingR) * _MPDFK) );

					$empty -= ($jcharspacing * ($nb_carac - 1)); // mPDF 6 nb_carac MINUS 1
					$empty -= ($jws * $nb_spaces);
					$empty -= ($jkashida);
					$empty /= _MPDFK;

					$b = ''; //do not use borders
					// Get PAGEBREAK TO TEST for height including the top border/padding
					$check_h = max($this->divheight, $stackHeight);
					if (($newblock) && ($blockstate == 1 || $blockstate == 3) && ($this->blklvl > 0) && ($lineCount == 1) && (!$is_table)) {
						$check_h += ($this->blk[$this->blklvl]['padding_top'] + $this->blk[$this->blklvl]['margin_top'] + $this->blk[$this->blklvl]['border_top']['w']);
					}

					if ($this->ColActive && $check_h > ($this->PageBreakTrigger - $this->y0)) {
						$this->SetCol($this->NbCol - 1);
					}

					// PAGEBREAK
					// 'If' below used in order to fix "first-line of other page with justify on" bug
					if (!$is_table && ($this->y + $check_h) > $this->PageBreakTrigger and ! $this->InFooter and $this->AcceptPageBreak()) {
						$bak_x = $this->x; //Current X position
						// WORD SPACING
						$ws = $this->ws; //Word Spacing
						$charspacing = $this->charspacing; //Character Spacing
						$this->ResetSpacing();

						$this->AddPage($this->CurOrientation);

						$this->x = $bak_x;
						// Added to correct for OddEven Margins
						$currentx += $this->MarginCorrection;
						$this->x += $this->MarginCorrection;

						// WORD SPACING
						$this->SetSpacing($charspacing, $ws);
					}

					if ($this->kwt && !$is_table) { // mPDF 5.7+
						$this->printkwtbuffer();
						$this->kwt = false;
					}


					/* -- COLUMNS -- */
					// COLS
					// COLUMN CHANGE
					if ($this->CurrCol != $oldcolumn) {
						$currentx += $this->ChangeColumn * ($this->ColWidth + $this->ColGap);
						$this->x += $this->ChangeColumn * ($this->ColWidth + $this->ColGap);
						$oldcolumn = $this->CurrCol;
					}

					if ($this->ColActive && !$is_table) {
						$this->breakpoints[$this->CurrCol][] = $this->y;
					} // *COLUMNS*
					/* -- END COLUMNS -- */

					// TOP MARGIN
					if (($newblock) && ($blockstate == 1 || $blockstate == 3) && ($this->blk[$this->blklvl]['margin_top']) && ($lineCount == 1) && (!$is_table)) {
						$this->DivLn($this->blk[$this->blklvl]['margin_top'], $this->blklvl - 1, true, $this->blk[$this->blklvl]['margin_collapse']);
						if ($this->ColActive) {
							$this->breakpoints[$this->CurrCol][] = $this->y;
						} // *COLUMNS*
					}


					// Update y0 for top of block (used to paint border)
					if (($newblock) && ($blockstate == 1 || $blockstate == 3) && ($lineCount == 1) && (!$is_table)) {
						$this->blk[$this->blklvl]['y0'] = $this->y;
						$this->blk[$this->blklvl]['startpage'] = $this->page;
						if ($this->blk[$this->blklvl]['float']) {
							$this->blk[$this->blklvl]['float_start_y'] = $this->y;
						}
					}

					// TOP PADDING and BORDER spacing/fill
					if (($newblock) && ($blockstate == 1 || $blockstate == 3) && (($this->blk[$this->blklvl]['padding_top']) || ($this->blk[$this->blklvl]['border_top'])) && ($lineCount == 1) && (!$is_table)) {
						// $state = 0 normal; 1 top; 2 bottom; 3 top and bottom
						$this->DivLn($this->blk[$this->blklvl]['padding_top'] + $this->blk[$this->blklvl]['border_top']['w'], -3, true, false, 1);
						if ($this->ColActive) {
							$this->breakpoints[$this->CurrCol][] = $this->y;
						} // *COLUMNS*
					}

					$arraysize = count($chunkorder);

					$margins = ($this->cMarginL + $this->cMarginR) + ($ipaddingL + $ipaddingR + $fpaddingR + $fpaddingR );

					// PAINT BACKGROUND FOR THIS LINE
					if (!$is_table) {
						$this->DivLn($stackHeight, $this->blklvl, false);
					} // false -> don't advance y

					$this->x = $currentx + $this->cMarginL + $ipaddingL + $fpaddingL;
					if ($align == 'R') {
						$this->x += $empty;
					} elseif ($align == 'C') {
						$this->x += ($empty / 2);
					}

					// Paragraph INDENT
					if (isset($this->blk[$this->blklvl]['text_indent']) && ($newblock) && ($blockstate == 1 || $blockstate == 3) && ($lineCount == 1) && (!$is_table) && ($blockdir != 'rtl') && ($align != 'C')) {
						$ti = $this->ConvertSize($this->blk[$this->blklvl]['text_indent'], $this->blk[$this->blklvl]['inner_width'], $this->blk[$this->blklvl]['InlineProperties']['size'], false);  // mPDF 5.7.4
						$this->x += $ti;
					}

					// BIDI magic_reverse moved upwards from here

					foreach ($chunkorder AS $aord => $k) { // mPDF 5.7
						$chunk = $content[$aord];

						if (isset($this->objectbuffer[$k]) && $this->objectbuffer[$k]) {
							$xadj = $this->x - $this->objectbuffer[$k]['OUTER-X'];
							$this->objectbuffer[$k]['OUTER-X'] += $xadj;
							$this->objectbuffer[$k]['BORDER-X'] += $xadj;
							$this->objectbuffer[$k]['INNER-X'] += $xadj;

							if ($this->objectbuffer[$k]['type'] == 'listmarker') {
								$this->objectbuffer[$k]['lineBox'] = $lineBox[-1]; // Block element details for glyph-origin
							}
							$yadj = $this->y - $this->objectbuffer[$k]['OUTER-Y'];
							if ($this->objectbuffer[$k]['type'] == 'dottab') { // mPDF 6 DOTTAB
								$this->objectbuffer[$k]['lineBox'] = $lineBox[$k]; // element details for glyph-origin
							}
							if ($this->objectbuffer[$k]['type'] != 'dottab') { // mPDF 6 DOTTAB
								$yadj += $lineBox[$k]['top'];
							}
							$this->objectbuffer[$k]['OUTER-Y'] += $yadj;
							$this->objectbuffer[$k]['BORDER-Y'] += $yadj;
							$this->objectbuffer[$k]['INNER-Y'] += $yadj;
						}

						$this->restoreFont($font[$k]);  // mPDF 5.7

						$this->SetSpacing(($this->fixedlSpacing * _MPDFK) + $jcharspacing, ($this->fixedlSpacing + $this->minwSpacing) * _MPDFK + $jws);
						// Now unset these values so they don't influence GetStringwidth below or in fn. Cell
						$this->fixedlSpacing = false;
						$this->minwSpacing = 0;

						$save_vis = $this->visibility;
						if (isset($this->textparam['visibility']) && $this->textparam['visibility'] && $this->textparam['visibility'] != $this->visibility) {
							$this->SetVisibility($this->textparam['visibility']);
						}
						// *********** SPAN BACKGROUND COLOR ***************** //
						if ($this->spanbgcolor) {
							$cor = $this->spanbgcolorarray;
							$this->SetFColor($cor);
							$save_fill = $fill;
							$spanfill = 1;
							$fill = 1;
						}
						if (!empty($this->spanborddet)) {
							if (strpos($contentB[$k], 'L') !== false)
								$this->x += (isset($this->spanborddet['L']['w']) ? $this->spanborddet['L']['w'] : 0);
							if (strpos($contentB[$k], 'L') === false)
								$this->spanborddet['L']['s'] = $this->spanborddet['L']['w'] = 0;
							if (strpos($contentB[$k], 'R') === false)
								$this->spanborddet['R']['s'] = $this->spanborddet['R']['w'] = 0;
						}

						// WORD SPACING
						// StringWidth this time includes any kashida spacing
						$stringWidth = $this->GetStringWidth($chunk, true, (isset($cOTLdata[$aord]) ? $cOTLdata[$aord] : false), $this->textvar, true);

						$nch = mb_strlen($chunk, $this->mb_enc);
						// Use GPOS OTL
						if (isset($this->CurrentFont['useOTL']) && ($this->CurrentFont['useOTL'] & 0xFF)) {
							if (isset($cOTLdata[$aord]['group']) && $cOTLdata[$aord]['group']) {
								$nch -= substr_count($cOTLdata[$aord]['group'], 'M');
							}
						}
						$stringWidth += ( $this->charspacing * $nch / _MPDFK );

						$stringWidth += ( $this->ws * mb_substr_count($chunk, ' ', $this->mb_enc) / _MPDFK );

						if (isset($this->objectbuffer[$k])) {
							// LIST MARKERS	// mPDF 6  Lists
							if ($this->objectbuffer[$k]['type'] == 'image' && isset($this->objectbuffer[$k]['listmarker']) && $this->objectbuffer[$k]['listmarker'] && $this->objectbuffer[$k]['listmarkerposition'] == 'outside') {
								$stringWidth = 0;
							} else {
								$stringWidth = $this->objectbuffer[$k]['OUTER-WIDTH'];
							}
						}

						if ($stringWidth == 0) {
							$stringWidth = 0.000001;
						}

						if ($aord == $arraysize - 1) {
							$stringWidth -= ( $this->charspacing / _MPDFK );
							if ($this->checkCJK && $CJKoverflow && $align == 'J' && $this->allowCJKoverflow && $hanger && $this->CJKforceend) {
								// force-end overhang
								$this->Cell($stringWidth, $stackHeight, $chunk, '', 0, '', $fill, $this->HREF, $currentx, 0, 0, 'M', $fill, true, (isset($cOTLdata[$aord]) ? $cOTLdata[$aord] : false), $this->textvar, (isset($lineBox[$k]) ? $lineBox[$k] : false));
								$this->Cell($this->GetStringWidth($hanger), $stackHeight, $hanger, '', 1, '', $fill, $this->HREF, $currentx, 0, 0, 'M', $fill, true, (isset($cOTLdata[$aord]) ? $cOTLdata[$aord] : false), $this->textvar, (isset($lineBox[$k]) ? $lineBox[$k] : false));
							} else {
								$this->Cell($stringWidth, $stackHeight, $chunk, '', 1, '', $fill, $this->HREF, $currentx, 0, 0, 'M', $fill, true, (isset($cOTLdata[$aord]) ? $cOTLdata[$aord] : false), $this->textvar, (isset($lineBox[$k]) ? $lineBox[$k] : false)); //mono-style line or last part (skips line)
							}
						} else
							$this->Cell($stringWidth, $stackHeight, $chunk, '', 0, '', $fill, $this->HREF, 0, 0, 0, 'M', $fill, true, (isset($cOTLdata[$aord]) ? $cOTLdata[$aord] : false), $this->textvar, (isset($lineBox[$k]) ? $lineBox[$k] : false)); //first or middle part

						if (!empty($this->spanborddet)) {
							if (strpos($contentB[$k], 'R') !== false && $aord != $arraysize - 1)
								$this->x += $this->spanborddet['R']['w'];
						}
						// *********** SPAN BACKGROUND COLOR OFF - RESET BLOCK BGCOLOR ***************** //
						if (isset($spanfill) && $spanfill) {
							$fill = $save_fill;
							$spanfill = 0;
							if ($fill) {
								$this->SetFColor($bcor);
							}
						}
						if (isset($this->textparam['visibility']) && $this->textparam['visibility'] && $this->visibility != $save_vis) {
							$this->SetVisibility($save_vis);
						}
					}
				} elseif ($table_draft) {
					$this->y += $stackHeight;
				}

				if (!$is_table) {
					$this->maxPosR = max($this->maxPosR, ($this->w - $this->rMargin - $this->blk[$this->blklvl]['outer_right_margin']));
					$this->maxPosL = min($this->maxPosL, ($this->lMargin + $this->blk[$this->blklvl]['outer_left_margin']));
				}

				// move on to the next line, reset variables, tack on saved content and current char

				if (!$table_draft)
					$this->printobjectbuffer($is_table, $blockdir);
				$this->objectbuffer = array();


				/* -- CSS-IMAGE-FLOAT -- */
				// Update values if set to skipline
				if ($this->floatmargins) {
					$this->_advanceFloatMargins();
				}
				/* -- END CSS-IMAGE-FLOAT -- */

				// Reset lineheight
				$stackHeight = $this->divheight;
				$valign = 'M';

				$font = array();
				$content = array();
				$contentB = array();
				$cOTLdata = array(); // mPDF 5.7.1
				$contentWidth = 0;
				if (!empty($savedObj)) {
					$this->objectbuffer[] = $savedObj;
					$font[] = $savedFont;
					$content[] = '';
					$contentB[] = '';
					$cOTLdata[] = array(); // mPDF 5.7.1
					$contentWidth += $savedObj['OUTER-WIDTH'] * _MPDFK;
				}
				if (count($savedPreContent) > 0) {
					for ($ix = count($savedPreContent) - 1; $ix >= 0; $ix--) {
						$font[] = $savedPreFont[$ix];
						$content[] = $savedPreContent[$ix];
						$contentB[] = $savedPreContentB[$ix];
						if (!empty($sOTLdata)) {
							$cOTLdata[] = $savedPreOTLdata[$ix];
						}
						$this->restoreFont($savedPreFont[$ix]);
						$lbw = $rbw = 0; // Border widths
						if (!empty($this->spanborddet)) {
							$lbw = (isset($this->spanborddet['L']['w']) ? $this->spanborddet['L']['w'] : 0);
							$rbw = (isset($this->spanborddet['R']['w']) ? $this->spanborddet['R']['w'] : 0);
						}
						if ($ix > 0) {
							$contentWidth += $this->GetStringWidth($savedPreContent[$ix], true, (isset($savedPreOTLdata[$ix]) ? $savedPreOTLdata[$ix] : false), $this->textvar) * _MPDFK; // mPDF 5.7.1
							if (strpos($savedPreContentB[$ix], 'L') !== false)
								$contentWidth += $lbw;
							if (strpos($savedPreContentB[$ix], 'R') !== false)
								$contentWidth += $rbw;
						}
					}
					$savedPreContent = array();
					$savedPreContentB = array();
					$savedPreOTLdata = array(); // mPDF 5.7.1
					$savedPreFont = array();
					$content[(count($content) - 1)] .= $c;
				}
				else {
					$font[] = $savedFont;
					$content[] = $savedContent . $c;
					$contentB[] = $savedContentB;
					$cOTLdata[] = $savedOTLdata; // mPDF 5.7.1
				}

				$currContent = & $content[(count($content) - 1)];
				$this->restoreFont($font[(count($font) - 1)]); // mPDF 6.0

				/* -- CJK-FONTS -- */
				// CJK - strip CJK space at start of line
				// &#x3000; = \xe3\x80\x80 = CJK space
				if ($this->checkCJK && $currContent == "\xe3\x80\x80") {
					$currContent = '';
					if (isset($this->CurrentFont['useOTL']) && $this->CurrentFont['useOTL']) {
						$this->otl->trimOTLdata($cOTLdata[count($cOTLdata) - 1], true, false); // left trim U+3000
					}
				}
				/* -- END CJK-FONTS -- */

				$lbw = $rbw = 0; // Border widths
				if (!empty($this->spanborddet)) {
					$lbw = (isset($this->spanborddet['L']['w']) ? $this->spanborddet['L']['w'] : 0);
					$rbw = (isset($this->spanborddet['R']['w']) ? $this->spanborddet['R']['w'] : 0);
				}

				$contentWidth += $this->GetStringWidth($currContent, false, (isset($cOTLdata[(count($cOTLdata) - 1)]) ? $cOTLdata[(count($cOTLdata) - 1)] : false), $this->textvar) * _MPDFK; // mPDF 5.7.1
				if (strpos($savedContentB, 'L') !== false)
					$contentWidth += $lbw;
				$CJKoverflow = false;
				$hanger = '';
			}
			// another character will fit, so add it on
			else {
				$contentWidth += $cw;
				$currContent .= $c;
			}
		}

		unset($content);
		unset($contentB);
	}

	//----------------------END OF FLOWING BLOCK------------------------------------//


	/* -- CSS-IMAGE-FLOAT -- */
	// Update values if set to skipline
	function _advanceFloatMargins()
	{
		// Update floatmargins - L
		if (isset($this->floatmargins['L']) && $this->floatmargins['L']['skipline'] && $this->floatmargins['L']['y0'] != $this->y) {
			$yadj = $this->y - $this->floatmargins['L']['y0'];
			$this->floatmargins['L']['y0'] = $this->y;
			$this->floatmargins['L']['y1'] += $yadj;

			// Update objattr in floatbuffer
			if ($this->floatbuffer[$this->floatmargins['L']['id']]['border_left']['w']) {
				$this->floatbuffer[$this->floatmargins['L']['id']]['BORDER-Y'] += $yadj;
			}
			$this->floatbuffer[$this->floatmargins['L']['id']]['INNER-Y'] += $yadj;
			$this->floatbuffer[$this->floatmargins['L']['id']]['OUTER-Y'] += $yadj;

			// Unset values
			$this->floatbuffer[$this->floatmargins['L']['id']]['skipline'] = false;
			$this->floatmargins['L']['skipline'] = false;
			$this->floatmargins['L']['id'] = '';
		}
		// Update floatmargins - R
		if (isset($this->floatmargins['R']) && $this->floatmargins['R']['skipline'] && $this->floatmargins['R']['y0'] != $this->y) {
			$yadj = $this->y - $this->floatmargins['R']['y0'];
			$this->floatmargins['R']['y0'] = $this->y;
			$this->floatmargins['R']['y1'] += $yadj;

			// Update objattr in floatbuffer
			if ($this->floatbuffer[$this->floatmargins['R']['id']]['border_left']['w']) {
				$this->floatbuffer[$this->floatmargins['R']['id']]['BORDER-Y'] += $yadj;
			}
			$this->floatbuffer[$this->floatmargins['R']['id']]['INNER-Y'] += $yadj;
			$this->floatbuffer[$this->floatmargins['R']['id']]['OUTER-Y'] += $yadj;

			// Unset values
			$this->floatbuffer[$this->floatmargins['R']['id']]['skipline'] = false;
			$this->floatmargins['R']['skipline'] = false;
			$this->floatmargins['R']['id'] = '';
		}
	}

	/* -- END CSS-IMAGE-FLOAT -- */



	/* -- END HTML-CSS -- */

	function _SetTextRendering($mode)
	{
		if (!(($mode == 0) || ($mode == 1) || ($mode == 2)))
			throw new MpdfException("Text rendering mode should be 0, 1 or 2 (value : $mode)");
		$tr = ($mode . ' Tr');
		if ($this->page > 0 && ((isset($this->pageoutput[$this->page]['TextRendering']) && $this->pageoutput[$this->page]['TextRendering'] != $tr) || !isset($this->pageoutput[$this->page]['TextRendering']))) {
			$this->_out($tr);
		}
		$this->pageoutput[$this->page]['TextRendering'] = $tr;
	}

	function SetTextOutline($params = array())
	{
		if (isset($params['outline-s']) && $params['outline-s']) {
			$this->SetLineWidth($params['outline-WIDTH']);
			$this->SetDColor($params['outline-COLOR']);
			$tr = ('2 Tr');
			if ($this->page > 0 && ((isset($this->pageoutput[$this->page]['TextRendering']) && $this->pageoutput[$this->page]['TextRendering'] != $tr) || !isset($this->pageoutput[$this->page]['TextRendering']))) {
				$this->_out($tr);
			}
			$this->pageoutput[$this->page]['TextRendering'] = $tr;
		} else { //Now resets all values
			$this->SetLineWidth(0.2);
			$this->SetDColor($this->ConvertColor(0));
			$this->_SetTextRendering(0);
			$tr = ('0 Tr');
			if ($this->page > 0 && ((isset($this->pageoutput[$this->page]['TextRendering']) && $this->pageoutput[$this->page]['TextRendering'] != $tr) || !isset($this->pageoutput[$this->page]['TextRendering']))) {
				$this->_out($tr);
			}
			$this->pageoutput[$this->page]['TextRendering'] = $tr;
		}
	}

	function Image($file, $x, $y, $w = 0, $h = 0, $type = '', $link = '', $paint = true, $constrain = true, $watermark = false, $shownoimg = true, $allowvector = true)
	{
		$orig_srcpath = $file;
		$this->GetFullPath($file);

		$info = $this->_getImage($file, true, $allowvector, $orig_srcpath);
		if (!$info && $paint) {
			$info = $this->_getImage($this->noImageFile);
			if ($info) {
				$file = $this->noImageFile;
				$w = ($info['w'] * (25.4 / $this->dpi));  // 14 x 16px
				$h = ($info['h'] * (25.4 / $this->dpi));  // 14 x 16px
			}
		}
		if (!$info)
			return false;
		//Automatic width and height calculation if needed
		if ($w == 0 and $h == 0) {
			/* -- IMAGES-WMF -- */
			if ($info['type'] == 'wmf') {
				// WMF units are twips (1/20pt)
				// divide by 20 to get points
				// divide by k to get user units
				$w = abs($info['w']) / (20 * _MPDFK);
				$h = abs($info['h']) / (20 * _MPDFK);
			} else
			/* -- END IMAGES-WMF -- */
			if ($info['type'] == 'svg') {
				// returned SVG units are pts
				// divide by k to get user units (mm)
				$w = abs($info['w']) / _MPDFK;
				$h = abs($info['h']) / _MPDFK;
			} else {
				//Put image at default image dpi
				$w = ($info['w'] / _MPDFK) * (72 / $this->img_dpi);
				$h = ($info['h'] / _MPDFK) * (72 / $this->img_dpi);
			}
		}
		if ($w == 0)
			$w = abs($h * $info['w'] / $info['h']);
		if ($h == 0)
			$h = abs($w * $info['h'] / $info['w']);

		/* -- WATERMARK -- */
		if ($watermark) {
			$maxw = $this->w;
			$maxh = $this->h;
			// Size = D PF or array
			if (is_array($this->watermark_size)) {
				$w = $this->watermark_size[0];
				$h = $this->watermark_size[1];
			} elseif (!is_string($this->watermark_size)) {
				$maxw -= $this->watermark_size * 2;
				$maxh -= $this->watermark_size * 2;
				$w = $maxw;
				$h = abs($w * $info['h'] / $info['w']);
				if ($h > $maxh) {
					$h = $maxh;
					$w = abs($h * $info['w'] / $info['h']);
				}
			} elseif ($this->watermark_size == 'F') {
				if ($this->ColActive) {
					$maxw = $this->w - ($this->DeflMargin + $this->DefrMargin);
				} else {
					$maxw = $this->pgwidth;
				}
				$maxh = $this->h - ($this->tMargin + $this->bMargin);
				$w = $maxw;
				$h = abs($w * $info['h'] / $info['w']);
				if ($h > $maxh) {
					$h = $maxh;
					$w = abs($h * $info['w'] / $info['h']);
				}
			} elseif ($this->watermark_size == 'P') { // Default P
				$w = $maxw;
				$h = abs($w * $info['h'] / $info['w']);
				if ($h > $maxh) {
					$h = $maxh;
					$w = abs($h * $info['w'] / $info['h']);
				}
			}
			// Automatically resize to maximum dimensions of page if too large
			if ($w > $maxw) {
				$w = $maxw;
				$h = abs($w * $info['h'] / $info['w']);
			}
			if ($h > $maxh) {
				$h = $maxh;
				$w = abs($h * $info['w'] / $info['h']);
			}
			// Position
			if (is_array($this->watermark_pos)) {
				$x = $this->watermark_pos[0];
				$y = $this->watermark_pos[1];
			} elseif ($this->watermark_pos == 'F') { // centred on printable area
				if ($this->ColActive) { // *COLUMNS*
					if (($this->mirrorMargins) && (($this->page) % 2 == 0)) {
						$xadj = $this->DeflMargin - $this->DefrMargin;
					} // *COLUMNS*
					else {
						$xadj = 0;
					} // *COLUMNS*
					$x = ($this->DeflMargin - $xadj + ($this->w - ($this->DeflMargin + $this->DefrMargin)) / 2) - ($w / 2); // *COLUMNS*
				} // *COLUMNS*
				else {  // *COLUMNS*
					$x = ($this->lMargin + ($this->pgwidth) / 2) - ($w / 2);
				} // *COLUMNS*
				$y = ($this->tMargin + ($this->h - ($this->tMargin + $this->bMargin)) / 2) - ($h / 2);
			} else { // default P - centred on whole page
				$x = ($this->w / 2) - ($w / 2);
				$y = ($this->h / 2) - ($h / 2);
			}
			/* -- IMAGES-WMF -- */
			if ($info['type'] == 'wmf') {
				$sx = $w * _MPDFK / $info['w'];
				$sy = -$h * _MPDFK / $info['h'];
				$outstring = sprintf('q %.3F 0 0 %.3F %.3F %.3F cm /FO%d Do Q', $sx, $sy, $x * _MPDFK - $sx * $info['x'], (($this->h - $y) * _MPDFK) - $sy * $info['y'], $info['i']);
			} else
			/* -- END IMAGES-WMF -- */
			if ($info['type'] == 'svg') {
				$sx = $w * _MPDFK / $info['w'];
				$sy = -$h * _MPDFK / $info['h'];
				$outstring = sprintf('q %.3F 0 0 %.3F %.3F %.3F cm /FO%d Do Q', $sx, $sy, $x * _MPDFK - $sx * $info['x'], (($this->h - $y) * _MPDFK) - $sy * $info['y'], $info['i']);
			} else {
				$outstring = sprintf("q %.3F 0 0 %.3F %.3F %.3F cm /I%d Do Q", $w * _MPDFK, $h * _MPDFK, $x * _MPDFK, ($this->h - ($y + $h)) * _MPDFK, $info['i']);
			}

			if ($this->watermarkImgBehind) {
				$outstring = $this->watermarkImgAlpha . "\n" . $outstring . "\n" . $this->SetAlpha(1, 'Normal', true) . "\n";
				$this->pages[$this->page] = preg_replace('/(___BACKGROUND___PATTERNS' . $this->uniqstr . ')/', "\n" . $outstring . "\n" . '\\1', $this->pages[$this->page]);
			} else {
				$this->_out($outstring);
			}

			return 0;
		} // end of IF watermark
		/* -- END WATERMARK -- */

		if ($constrain) {
			// Automatically resize to maximum dimensions of page if too large
			if (isset($this->blk[$this->blklvl]['inner_width']) && $this->blk[$this->blklvl]['inner_width']) {
				$maxw = $this->blk[$this->blklvl]['inner_width'];
			} else {
				$maxw = $this->pgwidth;
			}
			if ($w > $maxw) {
				$w = $maxw;
				$h = abs($w * $info['h'] / $info['w']);
			}
			if ($h > $this->h - ($this->tMargin + $this->bMargin + 1)) {  // see below - +10 to avoid drawing too close to border of page
				$h = $this->h - ($this->tMargin + $this->bMargin + 1);
				if ($this->fullImageHeight) {
					$h = $this->fullImageHeight;
				}
				$w = abs($h * $info['w'] / $info['h']);
			}


			//Avoid drawing out of the paper(exceeding width limits).
			//if ( ($x + $w) > $this->fw ) {
			if (($x + $w) > $this->w) {
				$x = $this->lMargin;
				$y += 5;
			}

			$changedpage = false;
			$oldcolumn = $this->CurrCol;
			//Avoid drawing out of the page.
			if ($y + $h > $this->PageBreakTrigger and ! $this->InFooter and $this->AcceptPageBreak()) {
				$this->AddPage($this->CurOrientation);
				// Added to correct for OddEven Margins
				$x = $x + $this->MarginCorrection;
				$y = $this->tMargin; // mPDF 5.7.3
				$changedpage = true;
			}
			/* -- COLUMNS -- */
			// COLS
			// COLUMN CHANGE
			if ($this->CurrCol != $oldcolumn) {
				$y = $this->y0;
				$x += $this->ChangeColumn * ($this->ColWidth + $this->ColGap);
				$this->x += $this->ChangeColumn * ($this->ColWidth + $this->ColGap);
			}
			/* -- END COLUMNS -- */
		} // end of IF constrain

		/* -- IMAGES-WMF -- */
		if ($info['type'] == 'wmf') {
			$sx = $w * _MPDFK / $info['w'];
			$sy = -$h * _MPDFK / $info['h'];
			$outstring = sprintf('q %.3F 0 0 %.3F %.3F %.3F cm /FO%d Do Q', $sx, $sy, $x * _MPDFK - $sx * $info['x'], (($this->h - $y) * _MPDFK) - $sy * $info['y'], $info['i']);
		} else
		/* -- END IMAGES-WMF -- */
		if ($info['type'] == 'svg') {
			$sx = $w * _MPDFK / $info['w'];
			$sy = -$h * _MPDFK / $info['h'];
			$outstring = sprintf('q %.3F 0 0 %.3F %.3F %.3F cm /FO%d Do Q', $sx, $sy, $x * _MPDFK - $sx * $info['x'], (($this->h - $y) * _MPDFK) - $sy * $info['y'], $info['i']);
		} else {
			$outstring = sprintf("q %.3F 0 0 %.3F %.3F %.3F cm /I%d Do Q", $w * _MPDFK, $h * _MPDFK, $x * _MPDFK, ($this->h - ($y + $h)) * _MPDFK, $info['i']);
		}

		if ($paint) {
			$this->_out($outstring);
			if ($link)
				$this->Link($x, $y, $w, $h, $link);

			// Avoid writing text on top of the image. // THIS WAS OUTSIDE THE if ($paint) bit!!!!!!!!!!!!!!!!
			$this->y = $y + $h;
		}

		//Return width-height array
		$sizesarray['WIDTH'] = $w;
		$sizesarray['HEIGHT'] = $h;
		$sizesarray['X'] = $x; //Position before painting image
		$sizesarray['Y'] = $y; //Position before painting image
		$sizesarray['OUTPUT'] = $outstring;

		$sizesarray['IMAGE_ID'] = $info['i'];
		$sizesarray['itype'] = $info['type'];
		$sizesarray['set-dpi'] = (isset($info['set-dpi']) ? $info['set-dpi'] : 0);
		return $sizesarray;
	}

	//=============================================================
	//=============================================================
	//=============================================================
	//=============================================================
	//=============================================================
	/* -- HTML-CSS -- */

	function _getObjAttr($t)
	{
		$c = explode("\xbb\xa4\xac", $t, 2);
		$c = explode(",", $c[1], 2);
		foreach ($c as $v) {
			$v = explode("=", $v, 2);
			$sp[$v[0]] = $v[1];
		}
		return (unserialize($sp['objattr']));
	}

	function inlineObject($type, $x, $y, $objattr, $Lmargin, $widthUsed, $maxWidth, $lineHeight, $paint = false, $is_table = false)
	{
		if ($is_table) {
			$k = $this->shrin_k;
		} else {
			$k = 1;
		}

		// NB $x is only used when paint=true
		// Lmargin not used
		$w = 0;
		if (isset($objattr['width'])) {
			$w = $objattr['width'] / $k;
		}
		$h = 0;
		if (isset($objattr['height'])) {
			$h = abs($objattr['height'] / $k);
		}
		$widthLeft = $maxWidth - $widthUsed;
		$maxHeight = $this->h - ($this->tMargin + $this->bMargin + 10);
		if ($this->fullImageHeight) {
			$maxHeight = $this->fullImageHeight;
		}
		// For Images
		if (isset($objattr['border_left'])) {
			$extraWidth = ($objattr['border_left']['w'] + $objattr['border_right']['w'] + $objattr['margin_left'] + $objattr['margin_right']) / $k;
			$extraHeight = ($objattr['border_top']['w'] + $objattr['border_bottom']['w'] + $objattr['margin_top'] + $objattr['margin_bottom']) / $k;

			if ($type == 'image' || $type == 'barcode' || $type == 'textcircle') {
				$extraWidth += ($objattr['padding_left'] + $objattr['padding_right']) / $k;
				$extraHeight += ($objattr['padding_top'] + $objattr['padding_bottom']) / $k;
			}
		}

		if (!isset($objattr['vertical-align'])) {
			if ($objattr['type'] == 'select') {
				$objattr['vertical-align'] = 'M';
			} else {
				$objattr['vertical-align'] = 'BS';
			}
		} // mPDF 6

		if ($type == 'image' || (isset($objattr['subtype']) && $objattr['subtype'] == 'IMAGE')) {
			if (isset($objattr['itype']) && ($objattr['itype'] == 'wmf' || $objattr['itype'] == 'svg')) {
				$file = $objattr['file'];
				$info = $this->formobjects[$file];
			} elseif (isset($objattr['file'])) {
				$file = $objattr['file'];
				$info = $this->images[$file];
			}
		}
		if ($type == 'annot' || $type == 'bookmark' || $type == 'indexentry' || $type == 'toc') {
			$w = 0.00001;
			$h = 0.00001;
		}

		// TEST whether need to skipline
		if (!$paint) {
			if ($type == 'hr') { // always force new line
				if (($y + $h + $lineHeight > $this->PageBreakTrigger) && !$this->InFooter && !$is_table) {
					return array(-2, $w, $h);
				} // New page + new line
				else {
					return array(1, $w, $h);
				} // new line
			} else {
				// LIST MARKERS	// mPDF 6  Lists
				$displayheight = $h;
				$displaywidth = $w;
				if ($objattr['type'] == 'image' && isset($objattr['listmarker']) && $objattr['listmarker']) {
					$displayheight = 0;
					if ($objattr['listmarkerposition'] == 'outside') {
						$displaywidth = 0;
					}
				}

				if ($widthUsed > 0 && $displaywidth > $widthLeft && (!$is_table || $type != 'image')) {  // New line needed
					// mPDF 6  Lists
					if (($y + $displayheight + $lineHeight > $this->PageBreakTrigger) && !$this->InFooter) {
						return array(-2, $w, $h);
					} // New page + new line
					return array(1, $w, $h); // new line
				} elseif ($widthUsed > 0 && $displaywidth > $widthLeft && $is_table) {  // New line needed in TABLE
					return array(1, $w, $h); // new line
				}
				// Will fit on line but NEW PAGE REQUIRED
				elseif (($y + $displayheight > $this->PageBreakTrigger) && !$this->InFooter && !$is_table) {
					return array(-1, $w, $h);
				} // mPDF 6  Lists
				else {
					return array(0, $w, $h);
				}
			}
		}

		if ($type == 'annot' || $type == 'bookmark' || $type == 'indexentry' || $type == 'toc') {
			$w = 0.00001;
			$h = 0.00001;
			$objattr['BORDER-WIDTH'] = 0;
			$objattr['BORDER-HEIGHT'] = 0;
			$objattr['BORDER-X'] = $x;
			$objattr['BORDER-Y'] = $y;
			$objattr['INNER-WIDTH'] = 0;
			$objattr['INNER-HEIGHT'] = 0;
			$objattr['INNER-X'] = $x;
			$objattr['INNER-Y'] = $y;
		}

		if ($type == 'image') {
			// Automatically resize to width remaining
			if ($w > ($widthLeft + 0.0001) && !$is_table) { // mPDF 5.7.4  0.0001 to allow for rounding errors when w==maxWidth
				$w = $widthLeft;
				$h = abs($w * $info['h'] / $info['w']);
			}
			$img_w = $w - $extraWidth;
			$img_h = $h - $extraHeight;

			$objattr['BORDER-WIDTH'] = $img_w + $objattr['padding_left'] / $k + $objattr['padding_right'] / $k + (($objattr['border_left']['w'] / $k + $objattr['border_right']['w'] / $k) / 2);
			$objattr['BORDER-HEIGHT'] = $img_h + $objattr['padding_top'] / $k + $objattr['padding_bottom'] / $k + (($objattr['border_top']['w'] / $k + $objattr['border_bottom']['w'] / $k) / 2);
			$objattr['BORDER-X'] = $x + $objattr['margin_left'] / $k + (($objattr['border_left']['w'] / $k) / 2);
			$objattr['BORDER-Y'] = $y + $objattr['margin_top'] / $k + (($objattr['border_top']['w'] / $k) / 2);
			$objattr['INNER-WIDTH'] = $img_w;
			$objattr['INNER-HEIGHT'] = $img_h;
			$objattr['INNER-X'] = $x + $objattr['padding_left'] / $k + $objattr['margin_left'] / $k + ($objattr['border_left']['w'] / $k);
			$objattr['INNER-Y'] = $y + $objattr['padding_top'] / $k + $objattr['margin_top'] / $k + ($objattr['border_top']['w'] / $k);
			$objattr['ID'] = $info['i'];
		}

		if ($type == 'input' && $objattr['subtype'] == 'IMAGE') {
			$img_w = $w - $extraWidth;
			$img_h = $h - $extraHeight;
			$objattr['BORDER-WIDTH'] = $img_w + (($objattr['border_left']['w'] / $k + $objattr['border_right']['w'] / $k) / 2);
			$objattr['BORDER-HEIGHT'] = $img_h + (($objattr['border_top']['w'] / $k + $objattr['border_bottom']['w'] / $k) / 2);
			$objattr['BORDER-X'] = $x + $objattr['margin_left'] / $k + (($objattr['border_left']['w'] / $k) / 2);
			$objattr['BORDER-Y'] = $y + $objattr['margin_top'] / $k + (($objattr['border_top']['w'] / $k) / 2);
			$objattr['INNER-WIDTH'] = $img_w;
			$objattr['INNER-HEIGHT'] = $img_h;
			$objattr['INNER-X'] = $x + $objattr['margin_left'] / $k + ($objattr['border_left']['w'] / $k);
			$objattr['INNER-Y'] = $y + $objattr['margin_top'] / $k + ($objattr['border_top']['w'] / $k);
			$objattr['ID'] = $info['i'];
		}

		if ($type == 'barcode' || $type == 'textcircle') {
			$b_w = $w - $extraWidth;
			$b_h = $h - $extraHeight;
			$objattr['BORDER-WIDTH'] = $b_w + $objattr['padding_left'] / $k + $objattr['padding_right'] / $k + (($objattr['border_left']['w'] / $k + $objattr['border_right']['w'] / $k) / 2);
			$objattr['BORDER-HEIGHT'] = $b_h + $objattr['padding_top'] / $k + $objattr['padding_bottom'] / $k + (($objattr['border_top']['w'] / $k + $objattr['border_bottom']['w'] / $k) / 2);
			$objattr['BORDER-X'] = $x + $objattr['margin_left'] / $k + (($objattr['border_left']['w'] / $k) / 2);
			$objattr['BORDER-Y'] = $y + $objattr['margin_top'] / $k + (($objattr['border_top']['w'] / $k) / 2);
			$objattr['INNER-X'] = $x + $objattr['padding_left'] / $k + $objattr['margin_left'] / $k + ($objattr['border_left']['w'] / $k);
			$objattr['INNER-Y'] = $y + $objattr['padding_top'] / $k + $objattr['margin_top'] / $k + ($objattr['border_top']['w'] / $k);
			$objattr['INNER-WIDTH'] = $b_w;
			$objattr['INNER-HEIGHT'] = $b_h;
		}


		if ($type == 'textarea') {
			// Automatically resize to width remaining
			if ($w > $widthLeft && !$is_table) {
				$w = $widthLeft;
			}
			// This used to resize height to maximum remaining on page ? why. Causes problems when in table and causing a new column
			//	if (($y + $h > $this->PageBreakTrigger) && !$this->InFooter) {
			//		$h=$this->h - $y - $this->bMargin;
			//	}
		}

		if ($type == 'hr') {
			if ($is_table) {
				$objattr['INNER-WIDTH'] = $maxWidth * $objattr['W-PERCENT'] / 100;
				$objattr['width'] = $objattr['INNER-WIDTH'];
				$w = $maxWidth;
			} else {
				if ($w > $maxWidth) {
					$w = $maxWidth;
				}
				$objattr['INNER-WIDTH'] = $w;
				$w = $maxWidth;
			}
		}



		if (($type == 'select') || ($type == 'input' && ($objattr['subtype'] == 'TEXT' || $objattr['subtype'] == 'PASSWORD'))) {
			// Automatically resize to width remaining
			if ($w > $widthLeft && !$is_table) {
				$w = $widthLeft;
			}
		}

		if ($type == 'textarea' || $type == 'select' || $type == 'input') {
			if (isset($objattr['fontsize']))
				$objattr['fontsize'] /= $k;
			if (isset($objattr['linewidth']))
				$objattr['linewidth'] /= $k;
		}

		if (!isset($objattr['BORDER-Y'])) {
			$objattr['BORDER-Y'] = 0;
		}
		if (!isset($objattr['BORDER-X'])) {
			$objattr['BORDER-X'] = 0;
		}
		if (!isset($objattr['INNER-Y'])) {
			$objattr['INNER-Y'] = 0;
		}
		if (!isset($objattr['INNER-X'])) {
			$objattr['INNER-X'] = 0;
		}

		//Return width-height array
		$objattr['OUTER-WIDTH'] = $w;
		$objattr['OUTER-HEIGHT'] = $h;
		$objattr['OUTER-X'] = $x;
		$objattr['OUTER-Y'] = $y;
		return $objattr;
	}

	/* -- END HTML-CSS -- */

	//=============================================================
	//=============================================================
	//=============================================================
	//=============================================================
	//=============================================================

	function SetLineJoin($mode = 0)
	{
		$s = sprintf('%d j', $mode);
		if ($this->page > 0 && ((isset($this->pageoutput[$this->page]['LineJoin']) && $this->pageoutput[$this->page]['LineJoin'] != $s) || !isset($this->pageoutput[$this->page]['LineJoin']))) {
			$this->_out($s);
		}
		$this->pageoutput[$this->page]['LineJoin'] = $s;
	}

	function SetLineCap($mode = 2)
	{
		$s = sprintf('%d J', $mode);
		if ($this->page > 0 && ((isset($this->pageoutput[$this->page]['LineCap']) && $this->pageoutput[$this->page]['LineCap'] != $s) || !isset($this->pageoutput[$this->page]['LineCap']))) {
			$this->_out($s);
		}
		$this->pageoutput[$this->page]['LineCap'] = $s;
	}

	function SetDash($black = false, $white = false)
	{
		if ($black and $white)
			$s = sprintf('[%.3F %.3F] 0 d', $black * _MPDFK, $white * _MPDFK);
		else
			$s = '[] 0 d';
		if ($this->page > 0 && ((isset($this->pageoutput[$this->page]['Dash']) && $this->pageoutput[$this->page]['Dash'] != $s) || !isset($this->pageoutput[$this->page]['Dash']))) {
			$this->_out($s);
		}
		$this->pageoutput[$this->page]['Dash'] = $s;
	}

	function SetDisplayPreferences($preferences)
	{
		// String containing any or none of /HideMenubar/HideToolbar/HideWindowUI/DisplayDocTitle/CenterWindow/FitWindow
		$this->DisplayPreferences .= $preferences;
	}

	function Ln($h = '', $collapsible = 0)
	{
		// Added collapsible to allow collapsible top-margin on new page
		//Line feed; default value is last cell height
		$this->x = $this->lMargin + $this->blk[$this->blklvl]['outer_left_margin'];
		if ($collapsible && ($this->y == $this->tMargin) && (!$this->ColActive)) {
			$h = 0;
		}
		if (is_string($h))
			$this->y+=$this->lasth;
		else
			$this->y+=$h;
	}

	/* -- HTML-CSS -- */

	function DivLn($h, $level = -3, $move_y = true, $collapsible = false, $state = 0)
	{
		// $state = 0 normal; 1 top; 2 bottom; 3 top and bottom
		// Used in Columns and keep-with-table i.e. "kwt"
		// writes background block by block so it can be repositioned
		// and also used in writingFlowingBlock at top and bottom of blocks to move y (not to draw/paint anything)
		// adds lines (y) where DIV bgcolors are filled in
		// this->x is returned as it was
		// allows .00001 as nominal height used for bookmarks/annotations etc.
		if ($collapsible && (sprintf("%0.4f", $this->y) == sprintf("%0.4f", $this->tMargin)) && (!$this->ColActive)) {
			return;
		}

		// mPDF 6 Columns
		//   if ($collapsible && (sprintf("%0.4f", $this->y)==sprintf("%0.4f", $this->y0)) && ($this->ColActive) && $this->CurrCol == 0) { return; }	// *COLUMNS*
		if ($collapsible && (sprintf("%0.4f", $this->y) == sprintf("%0.4f", $this->y0)) && ($this->ColActive)) {
			return;
		} // *COLUMNS*
		// Still use this method if columns or keep-with-table, as it allows repositioning later
		// otherwise, now uses PaintDivBB()
		if (!$this->ColActive && !$this->kwt) {
			if ($move_y && !$this->ColActive) {
				$this->y += $h;
			}
			return;
		}

		if ($level == -3) {
			$level = $this->blklvl;
		}
		$firstblockfill = $this->GetFirstBlockFill();
		if ($firstblockfill && $this->blklvl > 0 && $this->blklvl >= $firstblockfill) {
			$last_x = 0;
			$last_w = 0;
			$last_fc = $this->FillColor;
			$bak_x = $this->x;
			$bak_h = $this->divheight;
			$this->divheight = 0; // Temporarily turn off divheight - as Cell() uses it to check for PageBreak
			for ($blvl = $firstblockfill; $blvl <= $level; $blvl++) {
				$this->x = $this->lMargin + $this->blk[$blvl]['outer_left_margin'];
				// mPDF 6
				if ($this->blk[$blvl]['bgcolor']) {
					$this->SetFColor($this->blk[$blvl]['bgcolorarray']);
				}
				if ($last_x != ($this->lMargin + $this->blk[$blvl]['outer_left_margin']) || ($last_w != $this->blk[$blvl]['width']) || $last_fc != $this->FillColor || (isset($this->blk[$blvl]['border_top']['s']) && $this->blk[$blvl]['border_top']['s']) || (isset($this->blk[$blvl]['border_bottom']['s']) && $this->blk[$blvl]['border_bottom']['s']) || (isset($this->blk[$blvl]['border_left']['s']) && $this->blk[$blvl]['border_left']['s']) || (isset($this->blk[$blvl]['border_right']['s']) && $this->blk[$blvl]['border_right']['s'])) {
					$x = $this->x;
					$this->Cell(($this->blk[$blvl]['width']), $h, '', '', 0, '', 1);
					$this->x = $x;
					if (!$this->keep_block_together && !$this->writingHTMLheader && !$this->writingHTMLfooter) {
						// $state = 0 normal; 1 top; 2 bottom; 3 top and bottom
						if ($blvl == $this->blklvl) {
							$this->PaintDivLnBorder($state, $blvl, $h);
						} else {
							$this->PaintDivLnBorder(0, $blvl, $h);
						}
					}
				}
				$last_x = $this->lMargin + $this->blk[$blvl]['outer_left_margin'];
				$last_w = $this->blk[$blvl]['width'];
				$last_fc = $this->FillColor;
			}
			// Reset current block fill
			if (isset($this->blk[$this->blklvl]['bgcolorarray'])) {
				$bcor = $this->blk[$this->blklvl]['bgcolorarray'];
				$this->SetFColor($bcor);
			}
			$this->x = $bak_x;
			$this->divheight = $bak_h;
		}
		if ($move_y) {
			$this->y += $h;
		}
	}

	/* -- END HTML-CSS -- */

	function SetX($x)
	{
		//Set x position
		if ($x >= 0)
			$this->x = $x;
		else
			$this->x = $this->w + $x;
	}

	function SetY($y)
	{
		//Set y position and reset x
		$this->x = $this->lMargin;
		if ($y >= 0)
			$this->y = $y;
		else
			$this->y = $this->h + $y;
	}

	function SetXY($x, $y)
	{
		//Set x and y positions
		$this->SetY($y);
		$this->SetX($x);
	}

	function Output($name = '', $dest = '')
	{
		//Output PDF to some destination
		if ($this->showStats) {
			echo '<div>Generated in ' . sprintf('%.2F', (microtime(true) - $this->time0)) . ' seconds</div>';
		}
		//Finish document if necessary
		if ($this->progressBar) {
			$this->UpdateProgressBar(1, '100', 'Finished');
		} // *PROGRESS-BAR*
		if ($this->state < 3)
			$this->Close();
		if ($this->progressBar) {
			$this->UpdateProgressBar(2, '100', 'Finished');
		} // *PROGRESS-BAR*
		// fn. error_get_last is only in PHP>=5.2
		if ($this->debug && function_exists('error_get_last') && error_get_last()) {
			$e = error_get_last();
			if (($e['type'] < 2048 && $e['type'] != 8) || (intval($e['type']) & intval(ini_get("error_reporting")))) {
				echo "<p>Error message detected - PDF file generation aborted.</p>";
				echo $e['message'] . '<br />';
				echo 'File: ' . $e['file'] . '<br />';
				echo 'Line: ' . $e['line'] . '<br />';
				exit;
			}
		}


		if (($this->PDFA || $this->PDFX) && $this->encrypted) {
			throw new MpdfException("PDFA1-b or PDFX/1-a does not permit encryption of documents.");
		}
		if (count($this->PDFAXwarnings) && (($this->PDFA && !$this->PDFAauto) || ($this->PDFX && !$this->PDFXauto))) {
			if ($this->PDFA) {
				echo '<div>WARNING - This file could not be generated as it stands as a PDFA1-b compliant file.</div>';
				echo '<div>These issues can be automatically fixed by mPDF using <i>$mpdf-&gt;PDFAauto=true;</i></div>';
				echo '<div>Action that mPDF will take to automatically force PDFA1-b compliance are shown in brackets.</div>';
			} else {
				echo '<div>WARNING - This file could not be generated as it stands as a PDFX/1-a compliant file.</div>';
				echo '<div>These issues can be automatically fixed by mPDF using <i>$mpdf-&gt;PDFXauto=true;</i></div>';
				echo '<div>Action that mPDF will take to automatically force PDFX/1-a compliance are shown in brackets.</div>';
			}
			echo '<div>Warning(s) generated:</div><ul>';
			$this->PDFAXwarnings = array_unique($this->PDFAXwarnings);
			foreach ($this->PDFAXwarnings AS $w) {
				echo '<li>' . $w . '</li>';
			}
			echo '</ul>';
			exit;
		}

		if ($this->showStats) {
			echo '<div>Compiled in ' . sprintf('%.2F', (microtime(true) - $this->time0)) . ' seconds (total)</div>';
			echo '<div>Peak Memory usage ' . number_format((memory_get_peak_usage(true) / (1024 * 1024)), 2) . ' MB</div>';
			echo '<div>PDF file size ' . number_format((strlen($this->buffer) / 1024)) . ' kB</div>';
			echo '<div>Number of fonts ' . count($this->fonts) . '</div>';
			exit;
		}


		if (is_bool($dest))
			$dest = $dest ? 'D' : 'F';
		$dest = strtoupper($dest);
		if ($dest == '') {
			if ($name == '') {
				$name = 'mpdf.pdf';
				$dest = 'I';
			} else {
				$dest = 'F';
			}
		}

		/* -- PROGRESS-BAR -- */
		if ($this->progressBar && ($dest == 'D' || $dest == 'I')) {
			if ($name == '') {
				$name = 'mpdf.pdf';
			}
			$tempfile = '_tempPDF' . uniqid(rand(1, 100000), true);
			//Save to local file
			$f = fopen(_MPDF_TEMP_PATH . $tempfile . '.pdf', 'wb');
			if (!$f)
				throw new MpdfException('Unable to create temporary output file: ' . $tempfile . '.pdf');
			fwrite($f, $this->buffer, strlen($this->buffer));
			fclose($f);
			$this->UpdateProgressBar(3, '', 'Finished');

			echo '<script type="text/javascript">

		var form = document.createElement("form");
		form.setAttribute("method", "post");
		form.setAttribute("action", "' . _MPDF_URI . 'includes/out.php");

		var hiddenField = document.createElement("input");
		hiddenField.setAttribute("type", "hidden");
		hiddenField.setAttribute("name", "filename");
		hiddenField.setAttribute("value", "' . $tempfile . '");
		form.appendChild(hiddenField);

		var hiddenField = document.createElement("input");
		hiddenField.setAttribute("type", "hidden");
		hiddenField.setAttribute("name", "dest");
		hiddenField.setAttribute("value", "' . $dest . '");
		form.appendChild(hiddenField);

		var hiddenField = document.createElement("input");
		hiddenField.setAttribute("type", "hidden");
		hiddenField.setAttribute("name", "opname");
		hiddenField.setAttribute("value", "' . $name . '");
		form.appendChild(hiddenField);

		var hiddenField = document.createElement("input");
		hiddenField.setAttribute("type", "hidden");
		hiddenField.setAttribute("name", "path");
		hiddenField.setAttribute("value", "' . urlencode(_MPDF_TEMP_PATH) . '");
		form.appendChild(hiddenField);

		document.body.appendChild(form);
		form.submit();

		</script>
		</div>
		</body>
		</html>';
			exit;
		}
		else {
			if ($this->progressBar) {
				$this->UpdateProgressBar(3, '', 'Finished');
			}
			/* -- END PROGRESS-BAR -- */

			switch ($dest) {
				case 'I':
					if ($this->debug && !$this->allow_output_buffering && ob_get_contents()) {
						echo "<p>Output has already been sent from the script - PDF file generation aborted.</p>";
						exit;
					}
					//Send to standard output
					if (PHP_SAPI != 'cli') {
						//We send to a browser
						header('Content-Type: application/pdf');
						if (headers_sent())
							throw new MpdfException('Some data has already been output to browser, can\'t send PDF file');
						if (!isset($_SERVER['HTTP_ACCEPT_ENCODING']) OR empty($_SERVER['HTTP_ACCEPT_ENCODING'])) {
							// don't use length if server using compression
							header('Content-Length: ' . strlen($this->buffer));
						}
						header('Content-disposition: inline; filename="' . $name . '"');
						header('Cache-Control: public, must-revalidate, max-age=0');
						header('Pragma: public');
						header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
						header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
					}
					echo $this->buffer;
					break;
				case 'D':
					//Download file
					header('Content-Description: File Transfer');
					if (headers_sent())
						throw new MpdfException('Some data has already been output to browser, can\'t send PDF file');
					header('Content-Transfer-Encoding: binary');
					header('Cache-Control: public, must-revalidate, max-age=0');
					header('Pragma: public');
					header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
					header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
					header('Content-Type: application/force-download');
					header('Content-Type: application/octet-stream', false);
					header('Content-Type: application/download', false);
					header('Content-Type: application/pdf', false);
					if (!isset($_SERVER['HTTP_ACCEPT_ENCODING']) OR empty($_SERVER['HTTP_ACCEPT_ENCODING'])) {
						// don't use length if server using compression
						header('Content-Length: ' . strlen($this->buffer));
					}
					header('Content-disposition: attachment; filename="' . $name . '"');
					echo $this->buffer;
					break;
				case 'F':
					//Save to local file
					$f = fopen($name, 'wb');
					if (!$f)
						throw new MpdfException('Unable to create output file: ' . $name);
					fwrite($f, $this->buffer, strlen($this->buffer));
					fclose($f);
					break;
				case 'S':
					//Return as a string
					return $this->buffer;
				default:
					throw new MpdfException('Incorrect output destination: ' . $dest);
			}
		} // *PROGRESS-BAR*
		//======================================================================================================
		// DELETE OLD TMP FILES - Housekeeping
		// Delete any files in tmp/ directory that are >1 hrs old
		$interval = 3600;
		if ($handle = @opendir(preg_replace('/\/$/', '', _MPDF_TEMP_PATH))) { // mPDF 5.7.3
			while (false !== ($file = readdir($handle))) {
				if (($file != "..") && ($file != ".") && !is_dir($file) && ((filemtime(_MPDF_TEMP_PATH . $file) + $interval) < time()) && (substr($file, 0, 1) !== '.') && ($file != 'dummy.txt')) { // mPDF 5.7.3
					unlink(_MPDF_TEMP_PATH . $file);
				}
			}
			closedir($handle);
		}
		//==============================================================================================================

		return '';
	}

	// *****************************************************************************
	//                                                                             *
	//                             Protected methods                               *
	//                                                                             *
	// *****************************************************************************
	function _dochecks()
	{
		//Check for locale-related bug
		if (1.1 == 1)
			throw new MpdfException('Don\'t alter the locale before including mPDF');
		//Check for decimal separator
		if (sprintf('%.1f', 1.0) != '1.0')
			setlocale(LC_NUMERIC, 'C');
		$mqr = ini_get("magic_quotes_runtime");
		if ($mqr) {
			throw new MpdfException('mPDF requires magic_quotes_runtime to be turned off e.g. by using ini_set("magic_quotes_runtime", 0);');
		}
	}

	function _puthtmlheaders()
	{
		$this->state = 2;
		$nb = $this->page;
		for ($n = 1; $n <= $nb; $n++) {
			if ($this->mirrorMargins && $n % 2 == 0) {
				$OE = 'E';
			} // EVEN
			else {
				$OE = 'O';
			}
			$this->page = $n;
			$pn = $this->docPageNum($n);
			if ($pn)
				$pnstr = $this->pagenumPrefix . $pn . $this->pagenumSuffix;
			else {
				$pnstr = '';
			}
			$pnt = $this->docPageNumTotal($n);
			if ($pnt)
				$pntstr = $this->nbpgPrefix . $pnt . $this->nbpgSuffix;
			else {
				$pntstr = '';
			}
			if (isset($this->saveHTMLHeader[$n][$OE])) {
				$html = $this->saveHTMLHeader[$n][$OE]['html'];
				$this->lMargin = $this->saveHTMLHeader[$n][$OE]['ml'];
				$this->rMargin = $this->saveHTMLHeader[$n][$OE]['mr'];
				$this->tMargin = $this->saveHTMLHeader[$n][$OE]['mh'];
				$this->bMargin = $this->saveHTMLHeader[$n][$OE]['mf'];
				$this->margin_header = $this->saveHTMLHeader[$n][$OE]['mh'];
				$this->margin_footer = $this->saveHTMLHeader[$n][$OE]['mf'];
				$this->w = $this->saveHTMLHeader[$n][$OE]['pw'];
				$this->h = $this->saveHTMLHeader[$n][$OE]['ph'];
				$rotate = (isset($this->saveHTMLHeader[$n][$OE]['rotate']) ? $this->saveHTMLHeader[$n][$OE]['rotate'] : null);
				$this->Reset();
				$this->pageoutput[$n] = array();
				$this->pgwidth = $this->w - $this->lMargin - $this->rMargin;
				$this->x = $this->lMargin;
				$this->y = $this->margin_header;
				$html = str_replace('{PAGENO}', $pnstr, $html);
				$html = str_replace($this->aliasNbPgGp, $pntstr, $html); // {nbpg}
				$html = str_replace($this->aliasNbPg, $nb, $html); // {nb}
				$html = preg_replace_callback('/\{DATE\s+(.*?)\}/', array($this, 'date_callback'), $html); // mPDF 5.7

				$this->HTMLheaderPageLinks = array();
				$this->HTMLheaderPageAnnots = array();
				$this->HTMLheaderPageForms = array();
				$this->pageBackgrounds = array();

				$this->writingHTMLheader = true;
				$this->WriteHTML($html, 4); // parameter 4 saves output to $this->headerbuffer
				$this->writingHTMLheader = false;
				$this->Reset();
				$this->pageoutput[$n] = array();

				$s = $this->PrintPageBackgrounds();
				$this->headerbuffer = $s . $this->headerbuffer;
				$os = '';
				if ($rotate) {
					$os .= sprintf('q 0 -1 1 0 0 %.3F cm ', ($this->w * _MPDFK));
					// To rotate the other way i.e. Header to left of page:
					//$os .= sprintf('q 0 1 -1 0 %.3F %.3F cm ',($this->h*_MPDFK), (($this->rMargin - $this->lMargin )*_MPDFK));
				}
				$os .= $this->headerbuffer;
				if ($rotate) {
					$os .= ' Q' . "\n";
				}

				// Writes over the page background but behind any other output on page
				$os = preg_replace('/\\\\/', '\\\\\\\\', $os);
				$this->pages[$n] = preg_replace('/(___HEADER___MARKER' . $this->uniqstr . ')/', "\n" . $os . "\n" . '\\1', $this->pages[$n]);

				$lks = $this->HTMLheaderPageLinks;
				foreach ($lks AS $lk) {
					if ($rotate) {
						$lw = $lk[2];
						$lh = $lk[3];
						$lk[2] = $lh;
						$lk[3] = $lw; // swap width and height
						$ax = $lk[0] / _MPDFK;
						$ay = $lk[1] / _MPDFK;
						$bx = $ay - ($lh / _MPDFK);
						$by = $this->w - $ax;
						$lk[0] = $bx * _MPDFK;
						$lk[1] = ($this->h - $by) * _MPDFK - $lw;
					}
					$this->PageLinks[$n][] = $lk;
				}
				/* -- FORMS -- */
				foreach ($this->HTMLheaderPageForms AS $f) {
					$this->mpdfform->forms[$f['n']] = $f;
				}
				/* -- END FORMS -- */
			}
			if (isset($this->saveHTMLFooter[$n][$OE])) {
				$html = $this->saveHTMLFooter[$this->page][$OE]['html'];
				$this->lMargin = $this->saveHTMLFooter[$n][$OE]['ml'];
				$this->rMargin = $this->saveHTMLFooter[$n][$OE]['mr'];
				$this->tMargin = $this->saveHTMLFooter[$n][$OE]['mh'];
				$this->bMargin = $this->saveHTMLFooter[$n][$OE]['mf'];
				$this->margin_header = $this->saveHTMLFooter[$n][$OE]['mh'];
				$this->margin_footer = $this->saveHTMLFooter[$n][$OE]['mf'];
				$this->w = $this->saveHTMLFooter[$n][$OE]['pw'];
				$this->h = $this->saveHTMLFooter[$n][$OE]['ph'];
				$rotate = (isset($this->saveHTMLFooter[$n][$OE]['rotate']) ? $this->saveHTMLFooter[$n][$OE]['rotate'] : null);
				$this->Reset();
				$this->pageoutput[$n] = array();
				$this->pgwidth = $this->w - $this->lMargin - $this->rMargin;
				$this->x = $this->lMargin;
				$top_y = $this->y = $this->h - $this->margin_footer;

				// if bottom-margin==0, corrects to avoid division by zero
				if ($this->y == $this->h) {
					$top_y = $this->y = ($this->h - 0.1);
				}
				$html = str_replace('{PAGENO}', $pnstr, $html);
				$html = str_replace($this->aliasNbPgGp, $pntstr, $html); // {nbpg}
				$html = str_replace($this->aliasNbPg, $nb, $html); // {nb}
				$html = preg_replace_callback('/\{DATE\s+(.*?)\}/', array($this, 'date_callback'), $html); // mPDF 5.7


				$this->HTMLheaderPageLinks = array();
				$this->HTMLheaderPageAnnots = array();
				$this->HTMLheaderPageForms = array();
				$this->pageBackgrounds = array();

				$this->writingHTMLfooter = true;
				$this->InFooter = true;
				$this->WriteHTML($html, 4); // parameter 4 saves output to $this->headerbuffer
				$this->InFooter = false;
				$this->Reset();
				$this->pageoutput[$n] = array();

				$fheight = $this->y - $top_y;
				$adj = -$fheight;

				$s = $this->PrintPageBackgrounds(-$adj);
				$this->headerbuffer = $s . $this->headerbuffer;
				$this->writingHTMLfooter = false; // mPDF 5.7.3  (moved after PrintPageBackgrounds so can adjust position of images in footer)

				$os = '';
				$os .= $this->StartTransform(true) . "\n";
				if ($rotate) {
					$os .= sprintf('q 0 -1 1 0 0 %.3F cm ', ($this->w * _MPDFK));
					// To rotate the other way i.e. Header to left of page:
					//$os .= sprintf('q 0 1 -1 0 %.3F %.3F cm ',($this->h*_MPDFK), (($this->rMargin - $this->lMargin )*_MPDFK));
				}
				$os .= $this->transformTranslate(0, $adj, true) . "\n";
				$os .= $this->headerbuffer;
				if ($rotate) {
					$os .= ' Q' . "\n";
				}
				$os .= $this->StopTransform(true) . "\n";
				// Writes over the page background but behind any other output on page
				$os = preg_replace('/\\\\/', '\\\\\\\\', $os);
				$this->pages[$n] = preg_replace('/(___HEADER___MARKER' . $this->uniqstr . ')/', "\n" . $os . "\n" . '\\1', $this->pages[$n]);

				$lks = $this->HTMLheaderPageLinks;
				foreach ($lks AS $lk) {
					$lk[1] -= $adj * _MPDFK;
					if ($rotate) {
						$lw = $lk[2];
						$lh = $lk[3];
						$lk[2] = $lh;
						$lk[3] = $lw; // swap width and height

						$ax = $lk[0] / _MPDFK;
						$ay = $lk[1] / _MPDFK;
						$bx = $ay - ($lh / _MPDFK);
						$by = $this->w - $ax;
						$lk[0] = $bx * _MPDFK;
						$lk[1] = ($this->h - $by) * _MPDFK - $lw;
					}
					$this->PageLinks[$n][] = $lk;
				}
				/* -- FORMS -- */
				foreach ($this->HTMLheaderPageForms AS $f) {
					$f['y'] += $adj;
					$this->mpdfform->forms[$f['n']] = $f;
				}
				/* -- END FORMS -- */
			}
		}
		$this->page = $nb;
		$this->state = 1;
	}

	function _putpages()
	{
		$nb = $this->page;
		$filter = ($this->compress) ? '/Filter /FlateDecode ' : '';

		if ($this->DefOrientation == 'P') {
			$defwPt = $this->fwPt;
			$defhPt = $this->fhPt;
		} else {
			$defwPt = $this->fhPt;
			$defhPt = $this->fwPt;
		}
		$annotid = (3 + 2 * $nb);

		// Active Forms
		$totaladdnum = 0;
		for ($n = 1; $n <= $nb; $n++) {
			if (isset($this->PageLinks[$n])) {
				$totaladdnum += count($this->PageLinks[$n]);
			}
			/* -- ANNOTATIONS -- */
			if (isset($this->PageAnnots[$n])) {
				foreach ($this->PageAnnots[$n] as $k => $pl) {
					if (!empty($pl['opt']['popup']) || !empty($pl['opt']['file'])) {
						$totaladdnum += 2;
					} else {
						$totaladdnum++;
					}
				}
			}
			/* -- END ANNOTATIONS -- */

			/* -- FORMS -- */
			if (count($this->mpdfform->forms) > 0) {
				$this->mpdfform->countPageForms($n, $totaladdnum);
			}
			/* -- END FORMS -- */
		}
		/* -- FORMS -- */
		// Make a note in the radio button group of the obj_id it will have
		$ctr = 0;
		if (count($this->mpdfform->form_radio_groups)) {
			foreach ($this->mpdfform->form_radio_groups AS $name => $frg) {
				$this->mpdfform->form_radio_groups[$name]['obj_id'] = $annotid + $totaladdnum + $ctr;
				$ctr++;
			}
		}
		/* -- END FORMS -- */

		// Select unused fonts (usually default font)
		$unused = array();
		foreach ($this->fonts as $fk => $font) {
			if (isset($font['type']) && $font['type'] == 'TTF' && !$font['used']) {
				$unused[] = $fk;
			}
		}


		for ($n = 1; $n <= $nb; $n++) {
			$thispage = $this->pages[$n];
			if (isset($this->OrientationChanges[$n])) {
				$hPt = $this->pageDim[$n]['w'] * _MPDFK;
				$wPt = $this->pageDim[$n]['h'] * _MPDFK;
				$owidthPt_LR = $this->pageDim[$n]['outer_width_TB'] * _MPDFK;
				$owidthPt_TB = $this->pageDim[$n]['outer_width_LR'] * _MPDFK;
			} else {
				$wPt = $this->pageDim[$n]['w'] * _MPDFK;
				$hPt = $this->pageDim[$n]['h'] * _MPDFK;
				$owidthPt_LR = $this->pageDim[$n]['outer_width_LR'] * _MPDFK;
				$owidthPt_TB = $this->pageDim[$n]['outer_width_TB'] * _MPDFK;
			}
			// Remove references to unused fonts (usually default font)
			foreach ($unused as $fk) {
				if ($this->fonts[$fk]['sip'] || $this->fonts[$fk]['smp']) {
					foreach ($this->fonts[$fk]['subsetfontids'] AS $k => $fid) {
						$thispage = preg_replace('/\s\/F' . $fid . ' \d[\d.]* Tf\s/is', ' ', $thispage);
					}
				} else {
					$thispage = preg_replace('/\s\/F' . $this->fonts[$fk]['i'] . ' \d[\d.]* Tf\s/is', ' ', $thispage);
				}
			}
			// Clean up repeated /GS1 gs statements
			// For some reason using + for repetition instead of {2,20} crashes PHP Script Interpreter ???
			$thispage = preg_replace('/(\/GS1 gs\n){2,20}/', "/GS1 gs\n", $thispage);

			$thispage = preg_replace('/(\s*___BACKGROUND___PATTERNS' . $this->uniqstr . '\s*)/', " ", $thispage);
			$thispage = preg_replace('/(\s*___HEADER___MARKER' . $this->uniqstr . '\s*)/', " ", $thispage);
			$thispage = preg_replace('/(\s*___PAGE___START' . $this->uniqstr . '\s*)/', " ", $thispage);
			$thispage = preg_replace('/(\s*___TABLE___BACKGROUNDS' . $this->uniqstr . '\s*)/', " ", $thispage);
			// mPDF 5.7.3 TRANSFORMS
			while (preg_match('/(\% BTR(.*?)\% ETR)/is', $thispage, $m)) {
				$thispage = preg_replace('/(\% BTR.*?\% ETR)/is', '', $thispage, 1) . "\n" . $m[2];
			}

			//Page
			$this->_newobj();
			$this->_out('<</Type /Page');
			$this->_out('/Parent 1 0 R');
			if (isset($this->OrientationChanges[$n])) {
				$this->_out(sprintf('/MediaBox [0 0 %.3F %.3F]', $hPt, $wPt));
				//If BleedBox is defined, it must be larger than the TrimBox, but smaller than the MediaBox
				$bleedMargin = $this->pageDim[$n]['bleedMargin'] * _MPDFK;
				if ($bleedMargin && ($owidthPt_TB || $owidthPt_LR)) {
					$x0 = $owidthPt_TB - $bleedMargin;
					$y0 = $owidthPt_LR - $bleedMargin;
					$x1 = $hPt - $owidthPt_TB + $bleedMargin;
					$y1 = $wPt - $owidthPt_LR + $bleedMargin;
					$this->_out(sprintf('/BleedBox [%.3F %.3F %.3F %.3F]', $x0, $y0, $x1, $y1));
				}
				$this->_out(sprintf('/TrimBox [%.3F %.3F %.3F %.3F]', $owidthPt_TB, $owidthPt_LR, ($hPt - $owidthPt_TB), ($wPt - $owidthPt_LR)));
				if (isset($this->OrientationChanges[$n]) && $this->displayDefaultOrientation) {
					if ($this->DefOrientation == 'P') {
						$this->_out('/Rotate 270');
					} else {
						$this->_out('/Rotate 90');
					}
				}
			}
			//elseif($wPt != $defwPt || $hPt != $defhPt) {
			else {
				$this->_out(sprintf('/MediaBox [0 0 %.3F %.3F]', $wPt, $hPt));
				$bleedMargin = $this->pageDim[$n]['bleedMargin'] * _MPDFK;
				if ($bleedMargin && ($owidthPt_TB || $owidthPt_LR)) {
					$x0 = $owidthPt_LR - $bleedMargin;
					$y0 = $owidthPt_TB - $bleedMargin;
					$x1 = $wPt - $owidthPt_LR + $bleedMargin;
					$y1 = $hPt - $owidthPt_TB + $bleedMargin;
					$this->_out(sprintf('/BleedBox [%.3F %.3F %.3F %.3F]', $x0, $y0, $x1, $y1));
				}
				$this->_out(sprintf('/TrimBox [%.3F %.3F %.3F %.3F]', $owidthPt_LR, $owidthPt_TB, ($wPt - $owidthPt_LR), ($hPt - $owidthPt_TB)));
			}
			$this->_out('/Resources 2 0 R');

			// Important to keep in RGB colorSpace when using transparency
			if (!$this->PDFA && !$this->PDFX) {
				if ($this->restrictColorSpace == 3)
					$this->_out('/Group << /Type /Group /S /Transparency /CS /DeviceCMYK >> ');
				elseif ($this->restrictColorSpace == 1)
					$this->_out('/Group << /Type /Group /S /Transparency /CS /DeviceGray >> ');
				else
					$this->_out('/Group << /Type /Group /S /Transparency /CS /DeviceRGB >> ');
			}

			$annotsnum = 0;
			$embeddedfiles = array(); // mPDF 5.7.2 /EmbeddedFiles

			if (isset($this->PageLinks[$n])) {
				$annotsnum += count($this->PageLinks[$n]);
			}
			/* -- ANNOTATIONS -- */
			if (isset($this->PageAnnots[$n])) {
				foreach ($this->PageAnnots[$n] as $k => $pl) {
					if (!empty($pl['opt']['file'])) {
						$embeddedfiles[$annotsnum + 1] = true;
					} // mPDF 5.7.2 /EmbeddedFiles
					if (!empty($pl['opt']['popup']) || !empty($pl['opt']['file'])) {
						$annotsnum += 2;
					} else {
						$annotsnum++;
					}
					$this->PageAnnots[$n][$k]['pageobj'] = $this->n;
				}
			}
			/* -- END ANNOTATIONS -- */

			/* -- FORMS -- */
			// Active Forms
			$formsnum = 0;
			if (count($this->mpdfform->forms) > 0) {
				foreach ($this->mpdfform->forms as $val) {
					if ($val['page'] == $n)
						$formsnum++;
				}
			}
			/* -- END FORMS -- */
			if ($annotsnum || $formsnum) {
				$s = '/Annots [ ';
				for ($i = 0; $i < $annotsnum; $i++) {
					if (!isset($embeddedfiles[$i])) {
						$s .= ($annotid + $i) . ' 0 R ';
					} // mPDF 5.7.2 /EmbeddedFiles
				}
				$annotid += $annotsnum;
				/* -- FORMS -- */
				if (count($this->mpdfform->forms) > 0) {
					$this->mpdfform->addFormIds($n, $s, $annotid);
				}
				/* -- END FORMS -- */
				$s .= '] ';
				$this->_out($s);
			}

			$this->_out('/Contents ' . ($this->n + 1) . ' 0 R>>');
			$this->_out('endobj');

			//Page content
			$this->_newobj();
			$p = ($this->compress) ? gzcompress($thispage) : $thispage;
			$this->_out('<<' . $filter . '/Length ' . strlen($p) . '>>');
			$this->_putstream($p);
			$this->_out('endobj');
		}
		$this->_putannots(); // mPDF 5.7.2
		//Pages root
		$this->offsets[1] = strlen($this->buffer);
		$this->_out('1 0 obj');
		$this->_out('<</Type /Pages');
		$kids = '/Kids [';
		for ($i = 0; $i < $nb; $i++)
			$kids.=(3 + 2 * $i) . ' 0 R ';
		$this->_out($kids . ']');
		$this->_out('/Count ' . $nb);
		$this->_out(sprintf('/MediaBox [0 0 %.3F %.3F]', $defwPt, $defhPt));
		$this->_out('>>');
		$this->_out('endobj');
	}

	function _putannots()
	{ // mPDF 5.7.2
		$filter = ($this->compress) ? '/Filter /FlateDecode ' : '';
		$nb = $this->page;
		for ($n = 1; $n <= $nb; $n++) {
			$annotobjs = array();
			if (isset($this->PageLinks[$n]) || isset($this->PageAnnots[$n]) || count($this->mpdfform->forms) > 0) {
				$wPt = $this->pageDim[$n]['w'] * _MPDFK;
				$hPt = $this->pageDim[$n]['h'] * _MPDFK;

				//Links
				if (isset($this->PageLinks[$n])) {
					foreach ($this->PageLinks[$n] as $key => $pl) {
						$this->_newobj();
						$annot = '';
						$rect = sprintf('%.3F %.3F %.3F %.3F', $pl[0], $pl[1], $pl[0] + $pl[2], $pl[1] - $pl[3]);
						$annot .= '<</Type /Annot /Subtype /Link /Rect [' . $rect . ']';
						$annot .= ' /Contents ' . $this->_UTF16BEtextstring($pl[4]);
						$annot .= ' /NM ' . $this->_textstring(sprintf('%04u-%04u', $n, $key));
						$annot .= ' /M ' . $this->_textstring('D:' . date('YmdHis'));
						$annot .= ' /Border [0 0 0]';
						// Use this (instead of /Border) to specify border around link
						//		$annot .= ' /BS <</W 1';	// Width on points; 0 = no line
						//		$annot .= ' /S /D';		// style - [S]olid, [D]ashed, [B]eveled, [I]nset, [U]nderline
						//		$annot .= ' /D [3 2]';		// Dash array - if dashed
						//		$annot .= ' >>';
						//		$annot .= ' /C [1 0 0]';	// Color RGB

						if ($this->PDFA || $this->PDFX) {
							$annot .= ' /F 28';
						}
						if (strpos($pl[4], '@') === 0) {
							$p = substr($pl[4], 1);
							//	$h=isset($this->OrientationChanges[$p]) ? $wPt : $hPt;
							$htarg = $this->pageDim[$p]['h'] * _MPDFK;
							$annot.=sprintf(' /Dest [%d 0 R /XYZ 0 %.3F null]>>', 1 + 2 * $p, $htarg);
						} elseif (is_string($pl[4])) {
							$annot .= ' /A <</S /URI /URI ' . $this->_textstring($pl[4]) . '>> >>';
						} else {
							$l = $this->links[$pl[4]];
							// may not be set if #link points to non-existent target
							if (isset($this->pageDim[$l[0]]['h'])) {
								$htarg = $this->pageDim[$l[0]]['h'] * _MPDFK;
							} else {
								$htarg = $this->h * _MPDFK;
							} // doesn't really matter
							$annot.=sprintf(' /Dest [%d 0 R /XYZ 0 %.3F null]>>', 1 + 2 * $l[0], $htarg - $l[1] * _MPDFK);
						}
						$this->_out($annot);
						$this->_out('endobj');
					}
				}


				/* -- ANNOTATIONS -- */
				if (isset($this->PageAnnots[$n])) {
					foreach ($this->PageAnnots[$n] as $key => $pl) {
						if ($pl['opt']['file']) {
							$FileAttachment = true;
						} else {
							$FileAttachment = false;
						}
						$this->_newobj();
						$annot = '';
						$pl['opt'] = array_change_key_case($pl['opt'], CASE_LOWER);
						$x = $pl['x'];
						if ($this->annotMargin <> 0 || $x == 0 || $x < 0) { // Odd page
							$x = ($wPt / _MPDFK) - $this->annotMargin;
						}
						$w = $h = 0;
						$a = $x * _MPDFK;
						$b = $hPt - ($pl['y'] * _MPDFK);
						$annot .= '<</Type /Annot ';
						if ($FileAttachment) {
							$annot .= '/Subtype /FileAttachment ';
							// Need to set a size for FileAttachment icons
							if ($pl['opt']['icon'] == 'Paperclip') {
								$w = 8.235;
								$h = 20;
							} // 7,17
							elseif ($pl['opt']['icon'] == 'Tag') {
								$w = 20;
								$h = 16;
							} elseif ($pl['opt']['icon'] == 'Graph') {
								$w = 20;
								$h = 20;
							} else {
								$w = 14;
								$h = 20;
							}  // PushPin
							$f = $pl['opt']['file'];
							$f = preg_replace('/^.*\//', '', $f);
							$f = preg_replace('/[^a-zA-Z0-9._]/', '', $f);
							$annot .= '/FS <</Type /Filespec /F (' . $f . ')';
							$annot .= '/EF <</F ' . ($this->n + 1) . ' 0 R>>';
							$annot .= '>>';
						} else {
							$annot .= '/Subtype /Text';
							$w = 20;
							$h = 20;  // mPDF 6
						}
						$rect = sprintf('%.3F %.3F %.3F %.3F', $a, $b - $h, $a + $w, $b);
						$annot .= ' /Rect [' . $rect . ']';

						// contents = description of file in free text
						$annot .= ' /Contents ' . $this->_UTF16BEtextstring($pl['txt']);

						$annot .= ' /NM ' . $this->_textstring(sprintf('%04u-%04u', $n, (2000 + $key)));
						$annot .= ' /M ' . $this->_textstring('D:' . date('YmdHis'));
						$annot .= ' /CreationDate ' . $this->_textstring('D:' . date('YmdHis'));
						$annot .= ' /Border [0 0 0]';
						if ($this->PDFA || $this->PDFX) {
							$annot .= ' /F 28';
							$annot .= ' /CA 1';
						} elseif ($pl['opt']['ca'] > 0) {
							$annot .= ' /CA ' . $pl['opt']['ca'];
						}

						$annotcolor = ' /C [';
						if (isset($pl['opt']['c']) AND $pl['opt']['c']) {
							$col = $pl['opt']['c'];
							if ($col{0} == 3 || $col{0} == 5) {
								$annotcolor .= sprintf("%.3F %.3F %.3F", ord($col{1}) / 255, ord($col{2}) / 255, ord($col{3}) / 255);
							} elseif ($col{0} == 1) {
								$annotcolor .= sprintf("%.3F", ord($col{1}) / 255);
							} elseif ($col{0} == 4 || $col{0} == 6) {
								$annotcolor .= sprintf("%.3F %.3F %.3F %.3F", ord($col{1}) / 100, ord($col{2}) / 100, ord($col{3}) / 100, ord($col{4}) / 100);
							} else {
								$annotcolor .= '1 1 0';
							}
						} else {
							$annotcolor .= '1 1 0';
						}
						$annotcolor .= ']';
						$annot .= $annotcolor;
						// Usually Author
						// Use as Title for fileattachment
						if (isset($pl['opt']['t']) AND is_string($pl['opt']['t'])) {
							$annot .= ' /T ' . $this->_UTF16BEtextstring($pl['opt']['t']);
						}
						if ($FileAttachment) {
							$iconsapp = array('Paperclip', 'Graph', 'PushPin', 'Tag');
						} else {
							$iconsapp = array('Comment', 'Help', 'Insert', 'Key', 'NewParagraph', 'Note', 'Paragraph');
						}
						if (isset($pl['opt']['icon']) AND in_array($pl['opt']['icon'], $iconsapp)) {
							$annot .= ' /Name /' . $pl['opt']['icon'];
						} elseif ($FileAttachment) {
							$annot .= ' /Name /PushPin';
						} else {
							$annot .= ' /Name /Note';
						}
						if (!$FileAttachment) {
							// /Subj is PDF 1.5 spec.
							if (isset($pl['opt']['subj']) && !$this->PDFA && !$this->PDFX) {
								$annot .= ' /Subj ' . $this->_UTF16BEtextstring($pl['opt']['subj']);
							}
							if (!empty($pl['opt']['popup'])) {
								$annot .= ' /Open true';
								$annot .= ' /Popup ' . ($this->n + 1) . ' 0 R';
							} else {
								$annot .= ' /Open false';
							}
						}
						$annot .= ' /P ' . $pl['pageobj'] . ' 0 R';
						$annot .= '>>';
						$this->_out($annot);
						$this->_out('endobj');

						if ($FileAttachment) {
							$file = @file_get_contents($pl['opt']['file']);
							if (!$file) {
								throw new MpdfException('mPDF Error: Cannot access file attachment - ' . $pl['opt']['file']);
							}
							$filestream = gzcompress($file);
							$this->_newobj();
							$this->_out('<</Type /EmbeddedFile');
							$this->_out('/Length ' . strlen($filestream));
							$this->_out('/Filter /FlateDecode');
							$this->_out('>>');
							$this->_putstream($filestream);
							$this->_out('endobj');
						} elseif (!empty($pl['opt']['popup'])) {
							$this->_newobj();
							$annot = '';
							if (is_array($pl['opt']['popup']) && isset($pl['opt']['popup'][0])) {
								$x = $pl['opt']['popup'][0] * _MPDFK;
							} else {
								$x = $pl['x'] * _MPDFK;
							}
							if (is_array($pl['opt']['popup']) && isset($pl['opt']['popup'][1])) {
								$y = $hPt - ($pl['opt']['popup'][1] * _MPDFK);
							} else {
								$y = $hPt - ($pl['y'] * _MPDFK);
							}
							if (is_array($pl['opt']['popup']) && isset($pl['opt']['popup'][2])) {
								$w = $pl['opt']['popup'][2] * _MPDFK;
							} else {
								$w = 180;
							}
							if (is_array($pl['opt']['popup']) && isset($pl['opt']['popup'][3])) {
								$h = $pl['opt']['popup'][3] * _MPDFK;
							} else {
								$h = 120;
							}
							$rect = sprintf('%.3F %.3F %.3F %.3F', $x, $y - $h, $x + $w, $y);
							$annot .= '<</Type /Annot /Subtype /Popup /Rect [' . $rect . ']';
							$annot .= ' /M ' . $this->_textstring('D:' . date('YmdHis'));
							if ($this->PDFA || $this->PDFX) {
								$annot .= ' /F 28';
							}
							$annot .= ' /Parent ' . ($this->n - 1) . ' 0 R';
							$annot .= '>>';
							$this->_out($annot);
							$this->_out('endobj');
						}
					}
				}
				/* -- END ANNOTATIONS -- */

				/* -- FORMS -- */
				// Active Forms
				if (count($this->mpdfform->forms) > 0) {
					$this->mpdfform->_putFormItems($n, $hPt);
				}
				/* -- END FORMS -- */
			}
		}
		/* -- FORMS -- */
		// Active Forms - Radio Button Group entries
		// Output Radio Button Group form entries (radio_on_obj_id already determined)
		if (count($this->mpdfform->form_radio_groups)) {
			$this->mpdfform->_putRadioItems($n);
		}
		/* -- END FORMS -- */
	}

	/* -- ANNOTATIONS -- */

	function Annotation($text, $x = 0, $y = 0, $icon = 'Note', $author = '', $subject = '', $opacity = 0, $colarray = false, $popup = '', $file = '')
	{
		if (is_array($colarray) && count($colarray) == 3) {
			$colarray = $this->ConvertColor('rgb(' . $colarray[0] . ',' . $colarray[1] . ',' . $colarray[2] . ')');
		}
		if ($colarray === false) {
			$colarray = $this->ConvertColor('yellow');
		}
		if ($x == 0) {
			$x = $this->x;
		}
		if ($y == 0) {
			$y = $this->y;
		}
		$page = $this->page;
		if ($page < 1) { // Document has not been started - assume it's for first page
			$page = 1;
			if ($x == 0) {
				$x = $this->lMargin;
			}
			if ($y == 0) {
				$y = $this->tMargin;
			}
		}

		if ($this->PDFA || $this->PDFX) {
			if (($this->PDFA && !$this->PDFAauto) || ($this->PDFX && !$this->PDFXauto)) {
				$this->PDFAXwarnings[] = "Annotation markers cannot be semi-transparent in PDFA1-b or PDFX/1-a, so they may make underlying text unreadable. (Annotation markers moved to right margin)";
			}
			$x = ($this->w) - $this->rMargin * 0.66;
		}
		if (!$this->annotMargin) {
			$y -= $this->FontSize / 2;
		}

		if (!$opacity && $this->annotMargin) {
			$opacity = 1;
		} elseif (!$opacity) {
			$opacity = $this->annotOpacity;
		}

		$an = array('txt' => $text, 'x' => $x, 'y' => $y, 'opt' => array('Icon' => $icon, 'T' => $author, 'Subj' => $subject, 'C' => $colarray, 'CA' => $opacity, 'popup' => $popup, 'file' => $file));

		if ($this->keep_block_together) { // don't write yet
			return;
		} elseif ($this->table_rotate) {
			$this->tbrot_Annots[$this->page][] = $an;
			return;
		} elseif ($this->kwt) {
			$this->kwt_Annots[$this->page][] = $an;
			return;
		}
		if ($this->writingHTMLheader || $this->writingHTMLfooter) {
			$this->HTMLheaderPageAnnots[] = $an;
			return;
		}
		//Put an Annotation on the page
		$this->PageAnnots[$page][] = $an;
		/* -- COLUMNS -- */
		// Save cross-reference to Column buffer
		$ref = count($this->PageAnnots[$this->page]) - 1;
		$this->columnAnnots[$this->CurrCol][INTVAL($this->x)][INTVAL($this->y)] = $ref;
		/* -- END COLUMNS -- */
	}

	/* -- END ANNOTATIONS -- */

	function _putfonts()
	{
		$nf = $this->n;
		foreach ($this->FontFiles as $fontkey => $info) {
			// TrueType embedded
			if (isset($info['type']) && $info['type'] == 'TTF' && !$info['sip'] && !$info['smp']) {
				$used = true;
				$asSubset = false;
				foreach ($this->fonts AS $k => $f) {
					if (isset($f['fontkey']) && $f['fontkey'] == $fontkey && $f['type'] == 'TTF') {
						$used = $f['used'];
						if ($used) {
							$nChars = (ord($f['cw'][0]) << 8) + ord($f['cw'][1]);
							$usage = intval(count($f['subset']) * 100 / $nChars);
							$fsize = $info['length1'];
							// Always subset the very large TTF files
							if ($fsize > ($this->maxTTFFilesize * 1024)) {
								$asSubset = true;
							} elseif ($usage < $this->percentSubset) {
								$asSubset = true;
							}
						}
						if ($this->PDFA || $this->PDFX)
							$asSubset = false;
						$this->fonts[$k]['asSubset'] = $asSubset;
						break;
					}
				}
				if ($used && !$asSubset) {
					//Font file embedding
					$this->_newobj();
					$this->FontFiles[$fontkey]['n'] = $this->n;
					$font = '';
					$originalsize = $info['length1'];
					if ($this->repackageTTF || $this->fonts[$fontkey]['TTCfontID'] > 0 || $this->fonts[$fontkey]['useOTL'] > 0) { // mPDF 5.7.1
						// First see if there is a cached compressed file
						if (file_exists(_MPDF_TTFONTDATAPATH . $fontkey . '.ps.z')) {
							$f = fopen(_MPDF_TTFONTDATAPATH . $fontkey . '.ps.z', 'rb');
							if (!$f) {
								throw new MpdfException('Font file .ps.z not found');
							}
							while (!feof($f)) {
								$font .= fread($f, 2048);
							}
							fclose($f);
							include(_MPDF_TTFONTDATAPATH . $fontkey . '.ps.php'); // sets $originalsize (of repackaged font)
						} else {
							if (!class_exists('TTFontFile', false)) {
								include(_MPDF_PATH . 'classes/ttfontsuni.php');
							}
							$ttf = new TTFontFile();
							$font = $ttf->repackageTTF($this->FontFiles[$fontkey]['ttffile'], $this->fonts[$fontkey]['TTCfontID'], $this->debugfonts, $this->fonts[$fontkey]['useOTL']); // mPDF 5.7.1

							$originalsize = strlen($font);
							$font = gzcompress($font);
							unset($ttf);
							if (is_writable(dirname(_MPDF_TTFONTDATAPATH . 'x'))) {
								$fh = fopen(_MPDF_TTFONTDATAPATH . $fontkey . '.ps.z', "wb");
								fwrite($fh, $font, strlen($font));
								fclose($fh);
								$fh = fopen(_MPDF_TTFONTDATAPATH . $fontkey . '.ps.php', "wb");
								$len = "<?php \n";
								$len.='$originalsize=' . $originalsize . ";\n";
								$len.="?>";
								fwrite($fh, $len, strlen($len));
								fclose($fh);
							}
						}
					} else {
						// First see if there is a cached compressed file
						if (file_exists(_MPDF_TTFONTDATAPATH . $fontkey . '.z')) {
							$f = fopen(_MPDF_TTFONTDATAPATH . $fontkey . '.z', 'rb');
							if (!$f) {
								throw new MpdfException('Font file not found');
							}
							while (!feof($f)) {
								$font .= fread($f, 2048);
							}
							fclose($f);
						} else {
							$f = fopen($this->FontFiles[$fontkey]['ttffile'], 'rb');
							if (!$f) {
								throw new MpdfException('Font file not found');
							}
							while (!feof($f)) {
								$font .= fread($f, 2048);
							}
							fclose($f);
							$font = gzcompress($font);
							if (is_writable(dirname(_MPDF_TTFONTDATAPATH . 'x'))) {
								$fh = fopen(_MPDF_TTFONTDATAPATH . $fontkey . '.z', "wb");
								fwrite($fh, $font, strlen($font));
								fclose($fh);
							}
						}
					}

					$this->_out('<</Length ' . strlen($font));
					$this->_out('/Filter /FlateDecode');
					$this->_out('/Length1 ' . $originalsize);
					$this->_out('>>');
					$this->_putstream($font);
					$this->_out('endobj');
				}
			}
		}

		$nfonts = count($this->fonts);
		$fctr = 1;
		foreach ($this->fonts as $k => $font) {
			//Font objects
			$type = $font['type'];
			$name = $font['name'];
			if ((!isset($font['used']) || !$font['used']) && $type == 'TTF') {
				continue;
			}
			if ($this->progressBar) {
				$this->UpdateProgressBar(2, intval($fctr * 100 / $nfonts), 'Writing Fonts');
				$fctr++;
			} // *PROGRESS-BAR*
			if (isset($font['asSubset'])) {
				$asSubset = $font['asSubset'];
			} else {
				$asSubset = '';
			}
			/* -- CJK-FONTS -- */
			if ($type == 'Type0') {  // = Adobe CJK Fonts
				$this->fonts[$k]['n'] = $this->n + 1;
				$this->_newobj();
				$this->_out('<</Type /Font');
				$this->_putType0($font);
			} else
			/* -- END CJK-FONTS -- */
			if ($type == 'core') {
				//Standard font
				$this->fonts[$k]['n'] = $this->n + 1;
				if ($this->PDFA || $this->PDFX) {
					throw new MpdfException('Core fonts are not allowed in PDF/A1-b or PDFX/1-a files (Times, Helvetica, Courier etc.)');
				}
				$this->_newobj();
				$this->_out('<</Type /Font');
				$this->_out('/BaseFont /' . $name);
				$this->_out('/Subtype /Type1');
				if ($name != 'Symbol' && $name != 'ZapfDingbats') {
					$this->_out('/Encoding /WinAnsiEncoding');
				}
				$this->_out('>>');
				$this->_out('endobj');
			}
			// TrueType embedded SUBSETS for SIP (CJK extB containing Supplementary Ideographic Plane 2)
			// Or Unicode Plane 1 - Supplementary Multilingual Plane
			elseif ($type == 'TTF' && ($font['sip'] || $font['smp'])) {
				if (!$font['used']) {
					continue;
				}
				$ssfaid = "AA";
				if (!class_exists('TTFontFile', false)) {
					include(_MPDF_PATH . 'classes/ttfontsuni.php');
				}
				$ttf = new TTFontFile();
				for ($sfid = 0; $sfid < count($font['subsetfontids']); $sfid++) {
					$this->fonts[$k]['n'][$sfid] = $this->n + 1;  // NB an array for subset
					$subsetname = 'MPDF' . $ssfaid . '+' . $font['name'];
					$ssfaid++;

					/* For some strange reason a subset ($sfid > 0) containing less than 97 characters causes an error
					  so fill up the array */
					for ($j = count($font['subsets'][$sfid]); $j < 98; $j++) {
						$font['subsets'][$sfid][$j] = 0;
					}

					$subset = $font['subsets'][$sfid];
					unset($subset[0]);
					$ttfontstream = $ttf->makeSubsetSIP($font['ttffile'], $subset, $font['TTCfontID'], $this->debugfonts, $font['useOTL']); // mPDF 5.7.1
					$ttfontsize = strlen($ttfontstream);
					$fontstream = gzcompress($ttfontstream);
					$widthstring = '';
					$toUnistring = '';


					foreach ($font['subsets'][$sfid] AS $cp => $u) {
						$w = $this->_getCharWidth($font['cw'], $u);
						if ($w !== false) {
							$widthstring .= $w . ' ';
						} else {
							$widthstring .= round($ttf->defaultWidth) . ' ';
						}
						if ($u > 65535) {
							$utf8 = chr(($u >> 18) + 240) . chr((($u >> 12) & 63) + 128) . chr((($u >> 6) & 63) + 128) . chr(($u & 63) + 128);
							$utf16 = mb_convert_encoding($utf8, 'UTF-16BE', 'UTF-8');
							$l1 = ord($utf16[0]);
							$h1 = ord($utf16[1]);
							$l2 = ord($utf16[2]);
							$h2 = ord($utf16[3]);
							$toUnistring .= sprintf("<%02s> <%02s%02s%02s%02s>\n", strtoupper(dechex($cp)), strtoupper(dechex($l1)), strtoupper(dechex($h1)), strtoupper(dechex($l2)), strtoupper(dechex($h2)));
						} else {
							$toUnistring .= sprintf("<%02s> <%04s>\n", strtoupper(dechex($cp)), strtoupper(dechex($u)));
						}
					}

					//Additional Type1 or TrueType font
					$this->_newobj();
					$this->_out('<</Type /Font');
					$this->_out('/BaseFont /' . $subsetname);
					$this->_out('/Subtype /TrueType');
					$this->_out('/FirstChar 0 /LastChar ' . (count($font['subsets'][$sfid]) - 1));
					$this->_out('/Widths ' . ($this->n + 1) . ' 0 R');
					$this->_out('/FontDescriptor ' . ($this->n + 2) . ' 0 R');
					$this->_out('/ToUnicode ' . ($this->n + 3) . ' 0 R');
					$this->_out('>>');
					$this->_out('endobj');

					//Widths
					$this->_newobj();
					$this->_out('[' . $widthstring . ']');
					$this->_out('endobj');

					//Descriptor
					$this->_newobj();
					$s = '<</Type /FontDescriptor /FontName /' . $subsetname . "\n";
					foreach ($font['desc'] as $kd => $v) {
						if ($kd == 'Flags') {
							$v = $v | 4;
							$v = $v & ~32;
						} // SYMBOLIC font flag
						$s.=' /' . $kd . ' ' . $v . "\n";
					}
					$s.='/FontFile2 ' . ($this->n + 2) . ' 0 R';
					$this->_out($s . '>>');
					$this->_out('endobj');

					// ToUnicode
					$this->_newobj();
					$toUni = "/CIDInit /ProcSet findresource begin\n";
					$toUni .= "12 dict begin\n";
					$toUni .= "begincmap\n";
					$toUni .= "/CIDSystemInfo\n";
					$toUni .= "<</Registry (Adobe)\n";
					$toUni .= "/Ordering (UCS)\n";
					$toUni .= "/Supplement 0\n";
					$toUni .= ">> def\n";
					$toUni .= "/CMapName /Adobe-Identity-UCS def\n";
					$toUni .= "/CMapType 2 def\n";
					$toUni .= "1 begincodespacerange\n";
					$toUni .= "<00> <FF>\n";
					//$toUni .= sprintf("<00> <%02s>\n", strtoupper(dechex(count($font['subsets'][$sfid])-1)));
					$toUni .= "endcodespacerange\n";
					$toUni .= count($font['subsets'][$sfid]) . " beginbfchar\n";
					$toUni .= $toUnistring;
					$toUni .= "endbfchar\n";
					$toUni .= "endcmap\n";
					$toUni .= "CMapName currentdict /CMap defineresource pop\n";
					$toUni .= "end\n";
					$toUni .= "end\n";
					$this->_out('<</Length ' . (strlen($toUni)) . '>>');
					$this->_putstream($toUni);
					$this->_out('endobj');

					//Font file
					$this->_newobj();
					$this->_out('<</Length ' . strlen($fontstream));
					$this->_out('/Filter /FlateDecode');
					$this->_out('/Length1 ' . $ttfontsize);
					$this->_out('>>');
					$this->_putstream($fontstream);
					$this->_out('endobj');
				} // foreach subset
				unset($ttf);
			}
			// TrueType embedded SUBSETS or FULL
			elseif ($type == 'TTF') {
				$this->fonts[$k]['n'] = $this->n + 1;
				if ($asSubset) {
					$ssfaid = "A";
					if (!class_exists('TTFontFile', false)) {
						include(_MPDF_PATH . 'classes/ttfontsuni.php');
					}
					$ttf = new TTFontFile();
					$fontname = 'MPDFA' . $ssfaid . '+' . $font['name'];
					$subset = $font['subset'];
					unset($subset[0]);
					$ttfontstream = $ttf->makeSubset($font['ttffile'], $subset, $font['TTCfontID'], $this->debugfonts, $font['useOTL']);
					$ttfontsize = strlen($ttfontstream);
					$fontstream = gzcompress($ttfontstream);
					$codeToGlyph = $ttf->codeToGlyph;
					unset($codeToGlyph[0]);
				} else {
					$fontname = $font['name'];
				}
				// Type0 Font
				// A composite font - a font composed of other fonts, organized hierarchically
				$this->_newobj();
				$this->_out('<</Type /Font');
				$this->_out('/Subtype /Type0');
				$this->_out('/BaseFont /' . $fontname . '');
				$this->_out('/Encoding /Identity-H');
				$this->_out('/DescendantFonts [' . ($this->n + 1) . ' 0 R]');
				$this->_out('/ToUnicode ' . ($this->n + 2) . ' 0 R');
				$this->_out('>>');
				$this->_out('endobj');

				// CIDFontType2
				// A CIDFont whose glyph descriptions are based on TrueType font technology
				$this->_newobj();
				$this->_out('<</Type /Font');
				$this->_out('/Subtype /CIDFontType2');
				$this->_out('/BaseFont /' . $fontname . '');
				$this->_out('/CIDSystemInfo ' . ($this->n + 2) . ' 0 R');
				$this->_out('/FontDescriptor ' . ($this->n + 3) . ' 0 R');
				if (isset($font['desc']['MissingWidth'])) {
					$this->_out('/DW ' . $font['desc']['MissingWidth'] . '');
				}

				if (!$asSubset && file_exists(_MPDF_TTFONTDATAPATH . $font['fontkey'] . '.cw')) {
					$w = '';
					$w = file_get_contents(_MPDF_TTFONTDATAPATH . $font['fontkey'] . '.cw');
					$this->_out($w);
				} else {
					$this->_putTTfontwidths($font, $asSubset, ($asSubset ? $ttf->maxUni : 0));
				}

				$this->_out('/CIDToGIDMap ' . ($this->n + 4) . ' 0 R');
				$this->_out('>>');
				$this->_out('endobj');

				// ToUnicode
				$this->_newobj();
				$toUni = "/CIDInit /ProcSet findresource begin\n";
				$toUni .= "12 dict begin\n";
				$toUni .= "begincmap\n";
				$toUni .= "/CIDSystemInfo\n";
				$toUni .= "<</Registry (Adobe)\n";
				$toUni .= "/Ordering (UCS)\n";
				$toUni .= "/Supplement 0\n";
				$toUni .= ">> def\n";
				$toUni .= "/CMapName /Adobe-Identity-UCS def\n";
				$toUni .= "/CMapType 2 def\n";
				$toUni .= "1 begincodespacerange\n";
				$toUni .= "<0000> <FFFF>\n";
				$toUni .= "endcodespacerange\n";
				$toUni .= "1 beginbfrange\n";
				$toUni .= "<0000> <FFFF> <0000>\n";
				$toUni .= "endbfrange\n";
				$toUni .= "endcmap\n";
				$toUni .= "CMapName currentdict /CMap defineresource pop\n";
				$toUni .= "end\n";
				$toUni .= "end\n";
				$this->_out('<</Length ' . (strlen($toUni)) . '>>');
				$this->_putstream($toUni);
				$this->_out('endobj');


				// CIDSystemInfo dictionary
				$this->_newobj();
				$this->_out('<</Registry (Adobe)');
				$this->_out('/Ordering (UCS)');
				$this->_out('/Supplement 0');
				$this->_out('>>');
				$this->_out('endobj');

				// Font descriptor
				$this->_newobj();
				$this->_out('<</Type /FontDescriptor');
				$this->_out('/FontName /' . $fontname);
				foreach ($font['desc'] as $kd => $v) {
					if ($asSubset && $kd == 'Flags') {
						$v = $v | 4;
						$v = $v & ~32;
					} // SYMBOLIC font flag
					$this->_out(' /' . $kd . ' ' . $v);
				}
				if ($font['panose']) {
					$this->_out(' /Style << /Panose <' . $font['panose'] . '> >>');
				}
				if ($asSubset) {
					$this->_out('/FontFile2 ' . ($this->n + 2) . ' 0 R');
				} elseif ($font['fontkey']) {
					// obj ID of a stream containing a TrueType font program
					$this->_out('/FontFile2 ' . $this->FontFiles[$font['fontkey']]['n'] . ' 0 R');
				}
				$this->_out('>>');
				$this->_out('endobj');

				// Embed CIDToGIDMap
				// A specification of the mapping from CIDs to glyph indices
				if ($asSubset) {
					$cidtogidmap = '';
					$cidtogidmap = str_pad('', 256 * 256 * 2, "\x00");
					foreach ($codeToGlyph as $cc => $glyph) {
						$cidtogidmap[$cc * 2] = chr($glyph >> 8);
						$cidtogidmap[$cc * 2 + 1] = chr($glyph & 0xFF);
					}
					$cidtogidmap = gzcompress($cidtogidmap);
				} else {
					// First see if there is a cached CIDToGIDMapfile
					$cidtogidmap = '';
					if (file_exists(_MPDF_TTFONTDATAPATH . $font['fontkey'] . '.cgm')) {
						$f = fopen(_MPDF_TTFONTDATAPATH . $font['fontkey'] . '.cgm', 'rb');
						while (!feof($f)) {
							$cidtogidmap .= fread($f, 2048);
						}
						fclose($f);
					} else {
						if (!class_exists('TTFontFile', false)) {
							include(_MPDF_PATH . 'classes/ttfontsuni.php');
						}
						$ttf = new TTFontFile();
						$charToGlyph = $ttf->getCTG($font['ttffile'], $font['TTCfontID'], $this->debugfonts, $font['useOTL']);
						$cidtogidmap = str_pad('', 256 * 256 * 2, "\x00");
						foreach ($charToGlyph as $cc => $glyph) {
							$cidtogidmap[$cc * 2] = chr($glyph >> 8);
							$cidtogidmap[$cc * 2 + 1] = chr($glyph & 0xFF);
						}
						unset($ttf);
						$cidtogidmap = gzcompress($cidtogidmap);
						if (is_writable(dirname(_MPDF_TTFONTDATAPATH . 'x'))) {
							$fh = fopen(_MPDF_TTFONTDATAPATH . $font['fontkey'] . '.cgm', "wb");
							fwrite($fh, $cidtogidmap, strlen($cidtogidmap));
							fclose($fh);
						}
					}
				}
				$this->_newobj();
				$this->_out('<</Length ' . strlen($cidtogidmap) . '');
				$this->_out('/Filter /FlateDecode');
				$this->_out('>>');
				$this->_putstream($cidtogidmap);
				$this->_out('endobj');

				//Font file
				if ($asSubset) {
					$this->_newobj();
					$this->_out('<</Length ' . strlen($fontstream));
					$this->_out('/Filter /FlateDecode');
					$this->_out('/Length1 ' . $ttfontsize);
					$this->_out('>>');
					$this->_putstream($fontstream);
					$this->_out('endobj');
					unset($ttf);
				}
			} else {
				throw new MpdfException('Unsupported font type: ' . $type . ' (' . $name . ')');
			}
		}
	}

	function _putTTfontwidths(&$font, $asSubset, $maxUni)
	{
		if ($asSubset && file_exists(_MPDF_TTFONTDATAPATH . $font['fontkey'] . '.cw127.php')) {
			include(_MPDF_TTFONTDATAPATH . $font['fontkey'] . '.cw127.php');
			$startcid = 128;
		} else {
			$rangeid = 0;
			$range = array();
			$prevcid = -2;
			$prevwidth = -1;
			$interval = false;
			$startcid = 1;
		}
		if ($asSubset) {
			$cwlen = $maxUni + 1;
		} else {
			$cwlen = (strlen($font['cw']) / 2);
		}

		// for each character
		for ($cid = $startcid; $cid < $cwlen; $cid++) {
			if ($cid == 128 && $asSubset && (!file_exists(_MPDF_TTFONTDATAPATH . $font['fontkey'] . '.cw127.php'))) {
				if (is_writable(dirname(_MPDF_TTFONTDATAPATH . 'x'))) {
					$fh = fopen(_MPDF_TTFONTDATAPATH . $font['fontkey'] . '.cw127.php', "wb");
					$cw127 = '<?php' . "\n";
					$cw127.='$rangeid=' . $rangeid . ";\n";
					$cw127.='$prevcid=' . $prevcid . ";\n";
					$cw127.='$prevwidth=' . $prevwidth . ";\n";
					if ($interval) {
						$cw127.='$interval=true' . ";\n";
					} else {
						$cw127.='$interval=false' . ";\n";
					}
					$cw127.='$range=' . var_export($range, true) . ";\n";
					$cw127.="?>";
					fwrite($fh, $cw127, strlen($cw127));
					fclose($fh);
				}
			}
			if ($font['cw'][$cid * 2] == "\00" && $font['cw'][$cid * 2 + 1] == "\00") {
				continue;
			}
			$width = (ord($font['cw'][$cid * 2]) << 8) + ord($font['cw'][$cid * 2 + 1]);
			if ($width == 65535) {
				$width = 0;
			}
			if ($asSubset && $cid > 255 && (!isset($font['subset'][$cid]) || !$font['subset'][$cid])) {
				continue;
			}
			if ($asSubset && $cid > 0xFFFF) {
				continue;
			} // mPDF 6
			if (!isset($font['dw']) || (isset($font['dw']) && $width != $font['dw'])) {
				if ($cid == ($prevcid + 1)) {
					// consecutive CID
					if ($width == $prevwidth) {
						if ($width == $range[$rangeid][0]) {
							$range[$rangeid][] = $width;
						} else {
							array_pop($range[$rangeid]);
							// new range
							$rangeid = $prevcid;
							$range[$rangeid] = array();
							$range[$rangeid][] = $prevwidth;
							$range[$rangeid][] = $width;
						}
						$interval = true;
						$range[$rangeid]['interval'] = true;
					} else {
						if ($interval) {
							// new range
							$rangeid = $cid;
							$range[$rangeid] = array();
							$range[$rangeid][] = $width;
						} else {
							$range[$rangeid][] = $width;
						}
						$interval = false;
					}
				} else {
					// new range
					$rangeid = $cid;
					$range[$rangeid] = array();
					$range[$rangeid][] = $width;
					$interval = false;
				}
				$prevcid = $cid;
				$prevwidth = $width;
			}
		}
		$w = $this->_putfontranges($range);
		$this->_out($w);
		if (!$asSubset) {
			if (is_writable(dirname(_MPDF_TTFONTDATAPATH . 'x'))) {
				$fh = fopen(_MPDF_TTFONTDATAPATH . $font['fontkey'] . '.cw', "wb");
				fwrite($fh, $w, strlen($w));
				fclose($fh);
			}
		}
	}

	function _putfontranges(&$range)
	{
		// optimize ranges
		$prevk = -1;
		$nextk = -1;
		$prevint = false;
		foreach ($range as $k => $ws) {
			$cws = count($ws);
			if (($k == $nextk) AND ( !$prevint) AND ( (!isset($ws['interval'])) OR ( $cws < 4))) {
				if (isset($range[$k]['interval'])) {
					unset($range[$k]['interval']);
				}
				$range[$prevk] = array_merge($range[$prevk], $range[$k]);
				unset($range[$k]);
			} else {
				$prevk = $k;
			}
			$nextk = $k + $cws;
			if (isset($ws['interval'])) {
				if ($cws > 3) {
					$prevint = true;
				} else {
					$prevint = false;
				}
				unset($range[$k]['interval']);
				--$nextk;
			} else {
				$prevint = false;
			}
		}
		// output data
		$w = '';
		foreach ($range as $k => $ws) {
			if (count(array_count_values($ws)) == 1) {
				// interval mode is more compact
				$w .= ' ' . $k . ' ' . ($k + count($ws) - 1) . ' ' . $ws[0];
			} else {
				// range mode
				$w .= ' ' . $k . ' [ ' . implode(' ', $ws) . ' ]' . "\n";
			}
		}
		return '/W [' . $w . ' ]';
	}

	function _putfontwidths(&$font, $cidoffset = 0)
	{
		ksort($font['cw']);
		unset($font['cw'][65535]);
		$rangeid = 0;
		$range = array();
		$prevcid = -2;
		$prevwidth = -1;
		$interval = false;
		// for each character
		foreach ($font['cw'] as $cid => $width) {
			$cid -= $cidoffset;
			if (!isset($font['dw']) || (isset($font['dw']) && $width != $font['dw'])) {
				if ($cid == ($prevcid + 1)) {
					// consecutive CID
					if ($width == $prevwidth) {
						if ($width == $range[$rangeid][0]) {
							$range[$rangeid][] = $width;
						} else {
							array_pop($range[$rangeid]);
							// new range
							$rangeid = $prevcid;
							$range[$rangeid] = array();
							$range[$rangeid][] = $prevwidth;
							$range[$rangeid][] = $width;
						}
						$interval = true;
						$range[$rangeid]['interval'] = true;
					} else {
						if ($interval) {
							// new range
							$rangeid = $cid;
							$range[$rangeid] = array();
							$range[$rangeid][] = $width;
						} else {
							$range[$rangeid][] = $width;
						}
						$interval = false;
					}
				} else {
					// new range
					$rangeid = $cid;
					$range[$rangeid] = array();
					$range[$rangeid][] = $width;
					$interval = false;
				}
				$prevcid = $cid;
				$prevwidth = $width;
			}
		}
		$this->_out($this->_putfontranges($range));
	}

	/* -- CJK-FONTS -- */

	// from class PDF_Chinese CJK EXTENSIONS
	function _putType0(&$font)
	{
		//Type0
		$this->_out('/Subtype /Type0');
		$this->_out('/BaseFont /' . $font['name'] . '-' . $font['CMap']);
		$this->_out('/Encoding /' . $font['CMap']);
		$this->_out('/DescendantFonts [' . ($this->n + 1) . ' 0 R]');
		$this->_out('>>');
		$this->_out('endobj');
		//CIDFont
		$this->_newobj();
		$this->_out('<</Type /Font');
		$this->_out('/Subtype /CIDFontType0');
		$this->_out('/BaseFont /' . $font['name']);

		$cidinfo = '/Registry ' . $this->_textstring('Adobe');
		$cidinfo .= ' /Ordering ' . $this->_textstring($font['registry']['ordering']);
		$cidinfo .= ' /Supplement ' . $font['registry']['supplement'];
		$this->_out('/CIDSystemInfo <<' . $cidinfo . '>>');

		$this->_out('/FontDescriptor ' . ($this->n + 1) . ' 0 R');
		if (isset($font['MissingWidth'])) {
			$this->_out('/DW ' . $font['MissingWidth'] . '');
		}
		$this->_putfontwidths($font, 31);
		$this->_out('>>');
		$this->_out('endobj');

		//Font descriptor
		$this->_newobj();
		$s = '<</Type /FontDescriptor /FontName /' . $font['name'];
		foreach ($font['desc'] as $k => $v) {
			if ($k != 'Style') {
				$s .= ' /' . $k . ' ' . $v . '';
			}
		}
		$this->_out($s . '>>');
		$this->_out('endobj');
	}

	/* -- END CJK-FONTS -- */

	function _putimages()
	{
		$filter = ($this->compress) ? '/Filter /FlateDecode ' : '';
		reset($this->images);
		while (list($file, $info) = each($this->images)) {
			$this->_newobj();
			$this->images[$file]['n'] = $this->n;
			$this->_out('<</Type /XObject');
			$this->_out('/Subtype /Image');
			$this->_out('/Width ' . $info['w']);
			$this->_out('/Height ' . $info['h']);
			if (isset($info['interpolation']) && $info['interpolation']) {
				$this->_out('/Interpolate true'); // mPDF 6 - image interpolation shall be performed by a conforming reader
			}
			if (isset($info['masked'])) {
				$this->_out('/SMask ' . ($this->n - 1) . ' 0 R');
			}
			// set color space
			$icc = false;
			if (isset($info['icc']) AND ( $info['icc'] !== false)) {
				// ICC Colour Space
				$icc = true;
				$this->_out('/ColorSpace [/ICCBased ' . ($this->n + 1) . ' 0 R]');
			} elseif ($info['cs'] == 'Indexed') {
				if ($this->PDFX || ($this->PDFA && $this->restrictColorSpace == 3)) {
					throw new MpdfException("PDFA1-b and PDFX/1-a files do not permit using mixed colour space (" . $file . ").");
				}
				$this->_out('/ColorSpace [/Indexed /DeviceRGB ' . (strlen($info['pal']) / 3 - 1) . ' ' . ($this->n + 1) . ' 0 R]');
			} else {
				$this->_out('/ColorSpace /' . $info['cs']);
				if ($info['cs'] == 'DeviceCMYK') {
					if ($this->PDFA && $this->restrictColorSpace != 3) {
						throw new MpdfException("PDFA1-b does not permit Images using mixed colour space (" . $file . ").");
					}
					if ($info['type'] == 'jpg') {
						$this->_out('/Decode [1 0 1 0 1 0 1 0]');
					}
				} elseif ($info['cs'] == 'DeviceRGB' && ($this->PDFX || ($this->PDFA && $this->restrictColorSpace == 3))) {
					throw new MpdfException("PDFA1-b and PDFX/1-a files do not permit using mixed colour space (" . $file . ").");
				}
			}
			$this->_out('/BitsPerComponent ' . $info['bpc']);
			if (isset($info['f']) && $info['f']) {
				$this->_out('/Filter /' . $info['f']);
			}
			if (isset($info['parms'])) {
				$this->_out($info['parms']);
			}
			if (isset($info['trns']) and is_array($info['trns'])) {
				$trns = '';
				for ($i = 0; $i < count($info['trns']); $i++)
					$trns.=$info['trns'][$i] . ' ' . $info['trns'][$i] . ' ';
				$this->_out('/Mask [' . $trns . ']');
			}
			$this->_out('/Length ' . strlen($info['data']) . '>>');
			$this->_putstream($info['data']);
			unset($this->images[$file]['data']);
			$this->_out('endobj');

			// ICC colour profile
			if ($icc) {
				$this->_newobj();
				$icc = ($this->compress) ? gzcompress($info['icc']) : $info['icc'];
				$this->_out('<</N ' . $info['ch'] . ' ' . $filter . '/Length ' . strlen($icc) . '>>');
				$this->_putstream($icc);
				$this->_out('endobj');
			}
			//Palette
			elseif ($info['cs'] == 'Indexed') {
				$this->_newobj();
				$pal = ($this->compress) ? gzcompress($info['pal']) : $info['pal'];
				$this->_out('<<' . $filter . '/Length ' . strlen($pal) . '>>');
				$this->_putstream($pal);
				$this->_out('endobj');
			}
		}
	}

	function _putinfo()
	{
		$this->_out('/Producer ' . $this->_UTF16BEtextstring('mPDF ' . mPDF_VERSION));
		if (!empty($this->title))
			$this->_out('/Title ' . $this->_UTF16BEtextstring($this->title));
		if (!empty($this->subject))
			$this->_out('/Subject ' . $this->_UTF16BEtextstring($this->subject));
		if (!empty($this->author))
			$this->_out('/Author ' . $this->_UTF16BEtextstring($this->author));
		if (!empty($this->keywords))
			$this->_out('/Keywords ' . $this->_UTF16BEtextstring($this->keywords));
		if (!empty($this->creator))
			$this->_out('/Creator ' . $this->_UTF16BEtextstring($this->creator));

		$z = date('O'); // +0200
		$offset = substr($z, 0, 3) . "'" . substr($z, 3, 2) . "'";
		$this->_out('/CreationDate ' . $this->_textstring(date('YmdHis') . $offset));
		$this->_out('/ModDate ' . $this->_textstring(date('YmdHis') . $offset));
		if ($this->PDFX) {
			$this->_out('/Trapped/False');
			$this->_out('/GTS_PDFXVersion(PDF/X-1a:2003)');
		}
	}

	function _putmetadata()
	{
		$this->_newobj();
		$this->MetadataRoot = $this->n;
		$Producer = 'mPDF ' . mPDF_VERSION;
		$z = date('O'); // +0200
		$offset = substr($z, 0, 3) . ':' . substr($z, 3, 2);
		$CreationDate = date('Y-m-d\TH:i:s') . $offset; // 2006-03-10T10:47:26-05:00 2006-06-19T09:05:17Z
		$uuid = sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x', mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0x0fff) | 0x4000, mt_rand(0, 0x3fff) | 0x8000, mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff));


		$m = '<?xpacket begin="' . chr(239) . chr(187) . chr(191) . '" id="W5M0MpCehiHzreSzNTczkc9d"?>' . "\n"; // begin = FEFF BOM
		$m .= ' <x:xmpmeta xmlns:x="adobe:ns:meta/" x:xmptk="3.1-701">' . "\n";
		$m .= '  <rdf:RDF xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#">' . "\n";
		$m .= '   <rdf:Description rdf:about="uuid:' . $uuid . '" xmlns:pdf="http://ns.adobe.com/pdf/1.3/">' . "\n";
		$m .= '    <pdf:Producer>' . $Producer . '</pdf:Producer>' . "\n";
		if (!empty($this->keywords)) {
			$m .= '    <pdf:Keywords>' . $this->keywords . '</pdf:Keywords>' . "\n";
		}
		$m .= '   </rdf:Description>' . "\n";

		$m .= '   <rdf:Description rdf:about="uuid:' . $uuid . '" xmlns:xmp="http://ns.adobe.com/xap/1.0/">' . "\n";
		$m .= '    <xmp:CreateDate>' . $CreationDate . '</xmp:CreateDate>' . "\n";
		$m .= '    <xmp:ModifyDate>' . $CreationDate . '</xmp:ModifyDate>' . "\n";
		$m .= '    <xmp:MetadataDate>' . $CreationDate . '</xmp:MetadataDate>' . "\n";
		if (!empty($this->creator)) {
			$m .= '    <xmp:CreatorTool>' . $this->creator . '</xmp:CreatorTool>' . "\n";
		}
		$m .= '   </rdf:Description>' . "\n";

		// DC elements
		$m .= '   <rdf:Description rdf:about="uuid:' . $uuid . '" xmlns:dc="http://purl.org/dc/elements/1.1/">' . "\n";
		$m .= '    <dc:format>application/pdf</dc:format>' . "\n";
		if (!empty($this->title)) {
			$m .= '    <dc:title>
	 <rdf:Alt>
	  <rdf:li xml:lang="x-default">' . $this->title . '</rdf:li>
	 </rdf:Alt>
	</dc:title>' . "\n";
		}
		if (!empty($this->keywords)) {
			$m .= '    <dc:subject>
	 <rdf:Bag>
	  <rdf:li>' . $this->keywords . '</rdf:li>
	 </rdf:Bag>
	</dc:subject>' . "\n";
		}
		if (!empty($this->subject)) {
			$m .= '    <dc:description>
	 <rdf:Alt>
	  <rdf:li xml:lang="x-default">' . $this->subject . '</rdf:li>
	 </rdf:Alt>
	</dc:description>' . "\n";
		}
		if (!empty($this->author)) {
			$m .= '    <dc:creator>
	 <rdf:Seq>
	  <rdf:li>' . $this->author . '</rdf:li>
	 </rdf:Seq>
	</dc:creator>' . "\n";
		}
		$m .= '   </rdf:Description>' . "\n";


		// This bit is specific to PDFX-1a
		if ($this->PDFX) {
			$m .= '   <rdf:Description rdf:about="uuid:' . $uuid . '" xmlns:pdfx="http://ns.adobe.com/pdfx/1.3/" pdfx:Apag_PDFX_Checkup="1.3" pdfx:GTS_PDFXConformance="PDF/X-1a:2003" pdfx:GTS_PDFXVersion="PDF/X-1:2003"/>' . "\n";
		}

		// This bit is specific to PDFA-1b
		elseif ($this->PDFA) {
			$m .= '   <rdf:Description rdf:about="uuid:' . $uuid . '" xmlns:pdfaid="http://www.aiim.org/pdfa/ns/id/" >' . "\n";
			$m .= '    <pdfaid:part>1</pdfaid:part>' . "\n";
			$m .= '    <pdfaid:conformance>B</pdfaid:conformance>' . "\n";
			$m .= '    <pdfaid:amd>2005</pdfaid:amd>' . "\n";
			$m .= '   </rdf:Description>' . "\n";
		}

		$m .= '   <rdf:Description rdf:about="uuid:' . $uuid . '" xmlns:xmpMM="http://ns.adobe.com/xap/1.0/mm/">' . "\n";
		$m .= '    <xmpMM:DocumentID>uuid:' . $uuid . '</xmpMM:DocumentID>' . "\n";
		$m .= '   </rdf:Description>' . "\n";
		$m .= '  </rdf:RDF>' . "\n";
		$m .= ' </x:xmpmeta>' . "\n";
		$m .= str_repeat(str_repeat(' ', 100) . "\n", 20); // 2-4kB whitespace padding required
		$m .= '<?xpacket end="w"?>'; // "r" read only
		$this->_out('<</Type/Metadata/Subtype/XML/Length ' . strlen($m) . '>>');
		$this->_putstream($m);
		$this->_out('endobj');
	}

	function _putoutputintent()
	{
		$this->_newobj();
		$this->OutputIntentRoot = $this->n;
		$this->_out('<</Type /OutputIntent');

		if ($this->PDFA) {
			$this->_out('/S /GTS_PDFA1');
			if ($this->ICCProfile) {
				$this->_out('/Info (' . preg_replace('/_/', ' ', $this->ICCProfile) . ')');
				$this->_out('/OutputConditionIdentifier (Custom)');
				$this->_out('/OutputCondition ()');
			} else {
				$this->_out('/Info (sRGB IEC61966-2.1)');
				$this->_out('/OutputConditionIdentifier (sRGB IEC61966-2.1)');
				$this->_out('/OutputCondition ()');
			}
			$this->_out('/DestOutputProfile ' . ($this->n + 1) . ' 0 R');
		} elseif ($this->PDFX) { // always a CMYK profile
			$this->_out('/S /GTS_PDFX');
			if ($this->ICCProfile) {
				$this->_out('/Info (' . preg_replace('/_/', ' ', $this->ICCProfile) . ')');
				$this->_out('/OutputConditionIdentifier (Custom)');
				$this->_out('/OutputCondition ()');
				$this->_out('/DestOutputProfile ' . ($this->n + 1) . ' 0 R');
			} else {
				$this->_out('/Info (CGATS TR 001)');
				$this->_out('/OutputConditionIdentifier (CGATS TR 001)');
				$this->_out('/OutputCondition (CGATS TR 001 (SWOP))');
				$this->_out('/RegistryName (http://www.color.org)');
			}
		}
		$this->_out('>>');
		$this->_out('endobj');

		if ($this->PDFX && !$this->ICCProfile) {
			return;
		} // no ICCProfile embedded

		$this->_newobj();
		if ($this->ICCProfile)
			$s = file_get_contents(_MPDF_PATH . 'iccprofiles/' . $this->ICCProfile . '.icc');
		else
			$s = file_get_contents(_MPDF_PATH . 'iccprofiles/sRGB_IEC61966-2-1.icc');
		if ($this->compress) {
			$s = gzcompress($s);
		}
		$this->_out('<<');
		if ($this->PDFX || ($this->PDFA && $this->restrictColorSpace == 3)) {
			$this->_out('/N 4');
		} else {
			$this->_out('/N 3');
		}
		if ($this->compress)
			$this->_out('/Filter /FlateDecode ');
		$this->_out('/Length ' . strlen($s) . '>>');
		$this->_putstream($s);
		$this->_out('endobj');
	}

	function _putcatalog()
	{
		$this->_out('/Type /Catalog');
		$this->_out('/Pages 1 0 R');
		if ($this->ZoomMode == 'fullpage')
			$this->_out('/OpenAction [3 0 R /Fit]');
		elseif ($this->ZoomMode == 'fullwidth')
			$this->_out('/OpenAction [3 0 R /FitH null]');
		elseif ($this->ZoomMode == 'real')
			$this->_out('/OpenAction [3 0 R /XYZ null null 1]');
		elseif (!is_string($this->ZoomMode))
			$this->_out('/OpenAction [3 0 R /XYZ null null ' . ($this->ZoomMode / 100) . ']');
		else
			$this->_out('/OpenAction [3 0 R /XYZ null null null]');
		if ($this->LayoutMode == 'single')
			$this->_out('/PageLayout /SinglePage');
		elseif ($this->LayoutMode == 'continuous')
			$this->_out('/PageLayout /OneColumn');
		elseif ($this->LayoutMode == 'twoleft')
			$this->_out('/PageLayout /TwoColumnLeft');
		elseif ($this->LayoutMode == 'tworight')
			$this->_out('/PageLayout /TwoColumnRight');
		elseif ($this->LayoutMode == 'two') {
			if ($this->mirrorMargins) {
				$this->_out('/PageLayout /TwoColumnRight');
			} else {
				$this->_out('/PageLayout /TwoColumnLeft');
			}
		}

		/* -- BOOKMARKS -- */
		if (count($this->BMoutlines) > 0) {
			$this->_out('/Outlines ' . $this->OutlineRoot . ' 0 R');
			$this->_out('/PageMode /UseOutlines');
		}
		/* -- END BOOKMARKS -- */
		if (is_int(strpos($this->DisplayPreferences, 'FullScreen')))
			$this->_out('/PageMode /FullScreen');

		// Metadata
		if ($this->PDFA || $this->PDFX) {
			$this->_out('/Metadata ' . $this->MetadataRoot . ' 0 R');
		}
		// OutputIntents
		if ($this->PDFA || $this->PDFX || $this->ICCProfile) {
			$this->_out('/OutputIntents [' . $this->OutputIntentRoot . ' 0 R]');
		}

		/* -- FORMS -- */
		if (count($this->mpdfform->forms) > 0) {
			$this->mpdfform->_putFormsCatalog();
		}
		/* -- END FORMS -- */
		if (isset($this->js)) {
			$this->_out('/Names << /JavaScript ' . ($this->n_js) . ' 0 R >> ');
		}

		if ($this->DisplayPreferences || $this->directionality == 'rtl' || $this->mirrorMargins) {
			$this->_out('/ViewerPreferences<<');
			if (is_int(strpos($this->DisplayPreferences, 'HideMenubar')))
				$this->_out('/HideMenubar true');
			if (is_int(strpos($this->DisplayPreferences, 'HideToolbar')))
				$this->_out('/HideToolbar true');
			if (is_int(strpos($this->DisplayPreferences, 'HideWindowUI')))
				$this->_out('/HideWindowUI true');
			if (is_int(strpos($this->DisplayPreferences, 'DisplayDocTitle')))
				$this->_out('/DisplayDocTitle true');
			if (is_int(strpos($this->DisplayPreferences, 'CenterWindow')))
				$this->_out('/CenterWindow true');
			if (is_int(strpos($this->DisplayPreferences, 'FitWindow')))
				$this->_out('/FitWindow true');
			// /PrintScaling is PDF 1.6 spec.
			if (is_int(strpos($this->DisplayPreferences, 'NoPrintScaling')) && !$this->PDFA && !$this->PDFX)
				$this->_out('/PrintScaling /None');
			if ($this->directionality == 'rtl')
				$this->_out('/Direction /R2L');
			// /Duplex is PDF 1.7 spec.
			if ($this->mirrorMargins && !$this->PDFA && !$this->PDFX) {
				// if ($this->DefOrientation=='P') $this->_out('/Duplex /DuplexFlipShortEdge');
				$this->_out('/Duplex /DuplexFlipLongEdge'); // PDF v1.7+
			}
			$this->_out('>>');
		}
		if ($this->open_layer_pane && ($this->hasOC || count($this->layers)))
			$this->_out('/PageMode /UseOC');

		if ($this->hasOC || count($this->layers)) {
			$p = $v = $h = $l = $loff = $lall = $as = '';
			if ($this->hasOC) {
				if (($this->hasOC & 1) == 1)
					$p = $this->n_ocg_print . ' 0 R';
				if (($this->hasOC & 2) == 2)
					$v = $this->n_ocg_view . ' 0 R';
				if (($this->hasOC & 4) == 4)
					$h = $this->n_ocg_hidden . ' 0 R';
				$as = "<</Event /Print /OCGs [$p $v $h] /Category [/Print]>> <</Event /View /OCGs [$p $v $h] /Category [/View]>>";
			}

			if (count($this->layers)) {
				foreach ($this->layers as $k => $layer) {
					if (strtolower($this->layerDetails[$k]['state']) == 'hidden') {
						$loff .= $layer['n'] . ' 0 R ';
					} else {
						$l .= $layer['n'] . ' 0 R ';
					}
					$lall .= $layer['n'] . ' 0 R ';
				}
			}
			$this->_out("/OCProperties <</OCGs [$p $v $h $lall] /D <</ON [$p $l] /OFF [$v $h $loff] ");
			$this->_out("/Order [$v $p $h $lall] ");
			if ($as)
				$this->_out("/AS [$as] ");
			$this->_out(">>>>");
		}
	}

	// Inactive function left for backwards compatability
	function SetUserRights($enable = true, $annots = "", $form = "", $signature = "")
	{
		// Does nothing
	}

	function _enddoc()
	{
		if ($this->progressBar) {
			$this->UpdateProgressBar(2, '10', 'Writing Headers & Footers');
		} // *PROGRESS-BAR*
		$this->_puthtmlheaders();
		if ($this->progressBar) {
			$this->UpdateProgressBar(2, '20', 'Writing Pages');
		} // *PROGRESS-BAR*
		// Remove references to unused fonts (usually default font)
		foreach ($this->fonts as $fk => $font) {
			if (isset($font['type']) && $font['type'] == 'TTF' && !$font['used']) {
				if ($font['sip'] || $font['smp']) {
					foreach ($font['subsetfontids'] AS $k => $fid) {
						foreach ($this->pages AS $pn => $page) {
							$this->pages[$pn] = preg_replace('/\s\/F' . $fid . ' \d[\d.]* Tf\s/is', ' ', $this->pages[$pn]);
						}
					}
				} else {
					foreach ($this->pages AS $pn => $page) {
						$this->pages[$pn] = preg_replace('/\s\/F' . $font['i'] . ' \d[\d.]* Tf\s/is', ' ', $this->pages[$pn]);
					}
				}
			}
		}

		if (count($this->layers)) {
			foreach ($this->pages AS $pn => $page) {
				preg_match_all('/\/OCZ-index \/ZI(\d+) BDC(.*?)(EMCZ)-index/is', $this->pages[$pn], $m1);
				preg_match_all('/\/OCBZ-index \/ZI(\d+) BDC(.*?)(EMCBZ)-index/is', $this->pages[$pn], $m2);
				preg_match_all('/\/OCGZ-index \/ZI(\d+) BDC(.*?)(EMCGZ)-index/is', $this->pages[$pn], $m3);
				$m = array();
				for ($i = 0; $i < 4; $i++) {
					$m[$i] = array_merge($m1[$i], $m2[$i], $m3[$i]);
				}
				if (count($m[0])) {
					$sortarr = array();
					for ($i = 0; $i < count($m[0]); $i++) {
						$key = $m[1][$i] * 2;
						if ($m[3][$i] == 'EMCZ')
							$key +=2; // background first then gradient then normal
						elseif ($m[3][$i] == 'EMCGZ')
							$key +=1;
						$sortarr[$i] = $key;
					}
					asort($sortarr);
					foreach ($sortarr AS $i => $k) {
						$this->pages[$pn] = str_replace($m[0][$i], '', $this->pages[$pn]);
						$this->pages[$pn] .= "\n" . $m[0][$i] . "\n";
					}
					$this->pages[$pn] = preg_replace('/\/OC[BG]{0,1}Z-index \/ZI(\d+) BDC/is', '/OC /ZI\\1 BDC ', $this->pages[$pn]);
					$this->pages[$pn] = preg_replace('/EMC[BG]{0,1}Z-index/is', 'EMC', $this->pages[$pn]);
				}
			}
		}

		$this->_putpages();
		if ($this->progressBar) {
			$this->UpdateProgressBar(2, '30', 'Writing document resources');
		} // *PROGRESS-BAR*

		$this->_putresources();
		//Info
		$this->_newobj();
		$this->InfoRoot = $this->n;
		$this->_out('<<');
		if ($this->progressBar) {
			$this->UpdateProgressBar(2, '80', 'Writing document info');
		} // *PROGRESS-BAR*
		$this->_putinfo();
		$this->_out('>>');
		$this->_out('endobj');

		// METADATA
		if ($this->PDFA || $this->PDFX) {
			$this->_putmetadata();
		}
		// OUTPUTINTENT
		if ($this->PDFA || $this->PDFX || $this->ICCProfile) {
			$this->_putoutputintent();
		}

		//Catalog
		$this->_newobj();
		$this->_out('<<');
		if ($this->progressBar) {
			$this->UpdateProgressBar(2, '90', 'Writing document catalog');
		} // *PROGRESS-BAR*
		$this->_putcatalog();
		$this->_out('>>');
		$this->_out('endobj');
		//Cross-ref
		$o = strlen($this->buffer);
		$this->_out('xref');
		$this->_out('0 ' . ($this->n + 1));
		$this->_out('0000000000 65535 f ');
		for ($i = 1; $i <= $this->n; $i++)
			$this->_out(sprintf('%010d 00000 n ', $this->offsets[$i]));
		//Trailer
		$this->_out('trailer');
		$this->_out('<<');
		$this->_puttrailer();
		$this->_out('>>');
		$this->_out('startxref');
		$this->_out($o);

		$this->buffer .= '%%EOF';
		$this->state = 3;
		/* -- IMPORTS -- */

		if ($this->enableImports && count($this->parsers) > 0) {
			foreach ($this->parsers as $k => $_) {
				$this->parsers[$k]->closeFile();
				$this->parsers[$k] = null;
				unset($this->parsers[$k]);
			}
		}
		/* -- END IMPORTS -- */
	}

	function _beginpage($orientation, $mgl = '', $mgr = '', $mgt = '', $mgb = '', $mgh = '', $mgf = '', $ohname = '', $ehname = '', $ofname = '', $efname = '', $ohvalue = 0, $ehvalue = 0, $ofvalue = 0, $efvalue = 0, $pagesel = '', $newformat = '')
	{
		if (!($pagesel && $this->page == 1 && (sprintf("%0.4f", $this->y) == sprintf("%0.4f", $this->tMargin)))) {
			$this->page++;
			$this->pages[$this->page] = '';
		}
		$this->state = 2;
		$resetHTMLHeadersrequired = false;

		if ($newformat) {
			$this->_setPageSize($newformat, $orientation);
		}
		/* -- CSS-PAGE -- */
		// Paged media (page-box)
		if ($pagesel || (isset($this->page_box['using']) && $this->page_box['using'])) {
			if ($pagesel || $this->page == 1) {
				$first = true;
			} else {
				$first = false;
			}
			if ($this->mirrorMargins && ($this->page % 2 == 0)) {
				$oddEven = 'E';
			} else {
				$oddEven = 'O';
			}
			if ($pagesel) {
				$psel = $pagesel;
			} elseif ($this->page_box['current']) {
				$psel = $this->page_box['current'];
			} else {
				$psel = '';
			}
			list($orientation, $mgl, $mgr, $mgt, $mgb, $mgh, $mgf, $hname, $fname, $bg, $resetpagenum, $pagenumstyle, $suppress, $marks, $newformat) = $this->SetPagedMediaCSS($psel, $first, $oddEven);
			if ($this->mirrorMargins && ($this->page % 2 == 0)) {
				if ($hname) {
					$ehvalue = 1;
					$ehname = $hname;
				} else {
					$ehvalue = -1;
				}
				if ($fname) {
					$efvalue = 1;
					$efname = $fname;
				} else {
					$efvalue = -1;
				}
			} else {
				if ($hname) {
					$ohvalue = 1;
					$ohname = $hname;
				} else {
					$ohvalue = -1;
				}
				if ($fname) {
					$ofvalue = 1;
					$ofname = $fname;
				} else {
					$ofvalue = -1;
				}
			}
			if ($resetpagenum || $pagenumstyle || $suppress) {
				$this->PageNumSubstitutions[] = array('from' => ($this->page), 'reset' => $resetpagenum, 'type' => $pagenumstyle, 'suppress' => $suppress);
			}
			// PAGED MEDIA - CROP / CROSS MARKS from @PAGE
			$this->show_marks = $marks;

			// Background color
			if (isset($bg['BACKGROUND-COLOR'])) {
				$cor = $this->ConvertColor($bg['BACKGROUND-COLOR']);
				if ($cor) {
					$this->bodyBackgroundColor = $cor;
				}
			} else {
				$this->bodyBackgroundColor = false;
			}

			/* -- BACKGROUNDS -- */
			if (isset($bg['BACKGROUND-GRADIENT'])) {
				$this->bodyBackgroundGradient = $bg['BACKGROUND-GRADIENT'];
			} else {
				$this->bodyBackgroundGradient = false;
			}

			// Tiling Patterns
			if (isset($bg['BACKGROUND-IMAGE']) && $bg['BACKGROUND-IMAGE']) {
				$ret = $this->SetBackground($bg, $this->pgwidth);
				if ($ret) {
					$this->bodyBackgroundImage = $ret;
				}
			} else {
				$this->bodyBackgroundImage = false;
			}
			/* -- END BACKGROUNDS -- */

			$this->page_box['current'] = $psel;
			$this->page_box['using'] = true;
		}
		/* -- END CSS-PAGE -- */

		//Page orientation
		if (!$orientation)
			$orientation = $this->DefOrientation;
		else {
			$orientation = strtoupper(substr($orientation, 0, 1));
			if ($orientation != $this->DefOrientation)
				$this->OrientationChanges[$this->page] = true;
		}
		if ($orientation != $this->CurOrientation || $newformat) {

			//Change orientation
			if ($orientation == 'P') {
				$this->wPt = $this->fwPt;
				$this->hPt = $this->fhPt;
				$this->w = $this->fw;
				$this->h = $this->fh;
				if (($this->forcePortraitHeaders || $this->forcePortraitMargins) && $this->DefOrientation == 'P') {
					$this->tMargin = $this->orig_tMargin;
					$this->bMargin = $this->orig_bMargin;
					$this->DeflMargin = $this->orig_lMargin;
					$this->DefrMargin = $this->orig_rMargin;
					$this->margin_header = $this->orig_hMargin;
					$this->margin_footer = $this->orig_fMargin;
				} else {
					$resetHTMLHeadersrequired = true;
				}
			} else {
				$this->wPt = $this->fhPt;
				$this->hPt = $this->fwPt;
				$this->w = $this->fh;
				$this->h = $this->fw;
				if (($this->forcePortraitHeaders || $this->forcePortraitMargins) && $this->DefOrientation == 'P') {
					$this->tMargin = $this->orig_lMargin;
					$this->bMargin = $this->orig_rMargin;
					$this->DeflMargin = $this->orig_bMargin;
					$this->DefrMargin = $this->orig_tMargin;
					$this->margin_header = $this->orig_hMargin;
					$this->margin_footer = $this->orig_fMargin;
				} else {
					$resetHTMLHeadersrequired = true;
				}
			}
			$this->CurOrientation = $orientation;
			$this->ResetMargins();
			$this->pgwidth = $this->w - $this->lMargin - $this->rMargin;
			$this->PageBreakTrigger = $this->h - $this->bMargin;
		}

		$this->pageDim[$this->page]['w'] = $this->w;
		$this->pageDim[$this->page]['h'] = $this->h;

		$this->pageDim[$this->page]['outer_width_LR'] = isset($this->page_box['outer_width_LR']) ? $this->page_box['outer_width_LR'] : 0;
		$this->pageDim[$this->page]['outer_width_TB'] = isset($this->page_box['outer_width_TB']) ? $this->page_box['outer_width_TB'] : 0;
		if (!isset($this->page_box['outer_width_LR']) && !isset($this->page_box['outer_width_TB'])) {
			$this->pageDim[$this->page]['bleedMargin'] = 0;
		} elseif ($this->bleedMargin <= $this->page_box['outer_width_LR'] && $this->bleedMargin <= $this->page_box['outer_width_TB']) {
			$this->pageDim[$this->page]['bleedMargin'] = $this->bleedMargin;
		} else {
			$this->pageDim[$this->page]['bleedMargin'] = min($this->page_box['outer_width_LR'], $this->page_box['outer_width_TB']) - 0.01;
		}

		// If Page Margins are re-defined
		// strlen()>0 is used to pick up (integer) 0, (string) '0', or set value
		if ((strlen($mgl) > 0 && $this->DeflMargin != $mgl) || (strlen($mgr) > 0 && $this->DefrMargin != $mgr) || (strlen($mgt) > 0 && $this->tMargin != $mgt) || (strlen($mgb) > 0 && $this->bMargin != $mgb) || (strlen($mgh) > 0 && $this->margin_header != $mgh) || (strlen($mgf) > 0 && $this->margin_footer != $mgf)) {
			if (strlen($mgl) > 0)
				$this->DeflMargin = $mgl;
			if (strlen($mgr) > 0)
				$this->DefrMargin = $mgr;
			if (strlen($mgt) > 0)
				$this->tMargin = $mgt;
			if (strlen($mgb) > 0)
				$this->bMargin = $mgb;
			if (strlen($mgh) > 0)
				$this->margin_header = $mgh;
			if (strlen($mgf) > 0)
				$this->margin_footer = $mgf;
			$this->ResetMargins();
			$this->SetAutoPageBreak($this->autoPageBreak, $this->bMargin);
			$this->pgwidth = $this->w - $this->lMargin - $this->rMargin;
			$resetHTMLHeadersrequired = true;
		}

		$this->ResetMargins();
		$this->pgwidth = $this->w - $this->lMargin - $this->rMargin;
		$this->SetAutoPageBreak($this->autoPageBreak, $this->bMargin);

		// Reset column top margin
		$this->y0 = $this->tMargin;

		$this->x = $this->lMargin;
		$this->y = $this->tMargin;
		$this->FontFamily = '';

		// HEADERS AND FOOTERS	// mPDF 6
		if ($ohvalue < 0 || strtoupper($ohvalue) == 'OFF') {
			$this->HTMLHeader = '';
			$resetHTMLHeadersrequired = true;
		} elseif ($ohname && $ohvalue > 0) {
			if (preg_match('/^html_(.*)$/i', $ohname, $n)) {
				$name = $n[1];
			} else {
				$name = $ohname;
			}
			if (isset($this->pageHTMLheaders[$name])) {
				$this->HTMLHeader = $this->pageHTMLheaders[$name];
			} else {
				$this->HTMLHeader = '';
			}
			$resetHTMLHeadersrequired = true;
		}

		if ($ehvalue < 0 || strtoupper($ehvalue) == 'OFF') {
			$this->HTMLHeaderE = '';
			$resetHTMLHeadersrequired = true;
		} elseif ($ehname && $ehvalue > 0) {
			if (preg_match('/^html_(.*)$/i', $ehname, $n)) {
				$name = $n[1];
			} else {
				$name = $ehname;
			}
			if (isset($this->pageHTMLheaders[$name])) {
				$this->HTMLHeaderE = $this->pageHTMLheaders[$name];
			} else {
				$this->HTMLHeaderE = '';
			}
			$resetHTMLHeadersrequired = true;
		}

		if ($ofvalue < 0 || strtoupper($ofvalue) == 'OFF') {
			$this->HTMLFooter = '';
			$resetHTMLHeadersrequired = true;
		} elseif ($ofname && $ofvalue > 0) {
			if (preg_match('/^html_(.*)$/i', $ofname, $n)) {
				$name = $n[1];
			} else {
				$name = $ofname;
			}
			if (isset($this->pageHTMLfooters[$name])) {
				$this->HTMLFooter = $this->pageHTMLfooters[$name];
			} else {
				$this->HTMLFooter = '';
			}
			$resetHTMLHeadersrequired = true;
		}

		if ($efvalue < 0 || strtoupper($efvalue) == 'OFF') {
			$this->HTMLFooterE = '';
			$resetHTMLHeadersrequired = true;
		} elseif ($efname && $efvalue > 0) {
			if (preg_match('/^html_(.*)$/i', $efname, $n)) {
				$name = $n[1];
			} else {
				$name = $efname;
			}
			if (isset($this->pageHTMLfooters[$name])) {
				$this->HTMLFooterE = $this->pageHTMLfooters[$name];
			} else {
				$this->HTMLFooterE = '';
			}
			$resetHTMLHeadersrequired = true;
		}
		if ($resetHTMLHeadersrequired) {
			$this->SetHTMLHeader($this->HTMLHeader);
			$this->SetHTMLHeader($this->HTMLHeaderE, 'E');
			$this->SetHTMLFooter($this->HTMLFooter);
			$this->SetHTMLFooter($this->HTMLFooterE, 'E');
		}


		if (($this->mirrorMargins) && (($this->page) % 2 == 0)) { // EVEN
			$this->_setAutoHeaderHeight($this->HTMLHeaderE);
			$this->_setAutoFooterHeight($this->HTMLFooterE);
		} else { // ODD or DEFAULT
			$this->_setAutoHeaderHeight($this->HTMLHeader);
			$this->_setAutoFooterHeight($this->HTMLFooter);
		}
		// Reset column top margin
		$this->y0 = $this->tMargin;

		$this->x = $this->lMargin;
		$this->y = $this->tMargin;
	}

	// mPDF 6
	function _setAutoHeaderHeight(&$htmlh)
	{
		if ($this->setAutoTopMargin == 'pad') {
			if (isset($htmlh['h']) && $htmlh['h']) {
				$h = $htmlh['h'];
			} // 5.7.3
			else {
				$h = 0;
			}
			$this->tMargin = $this->margin_header + $h + $this->orig_tMargin;
		} elseif ($this->setAutoTopMargin == 'stretch') {
			if (isset($htmlh['h']) && $htmlh['h']) {
				$h = $htmlh['h'];
			} // 5.7.3
			else {
				$h = 0;
			}
			$this->tMargin = max($this->orig_tMargin, $this->margin_header + $h + $this->autoMarginPadding);
		}
	}

	// mPDF 6
	function _setAutoFooterHeight(&$htmlf)
	{
		if ($this->setAutoBottomMargin == 'pad') {
			if (isset($htmlf['h']) && $htmlf['h']) {
				$h = $htmlf['h'];
			} // 5.7.3
			else {
				$h = 0;
			}
			$this->bMargin = $this->margin_footer + $h + $this->orig_bMargin;
			$this->PageBreakTrigger = $this->h - $this->bMargin;
		} elseif ($this->setAutoBottomMargin == 'stretch') {
			if (isset($htmlf['h']) && $htmlf['h']) {
				$h = $htmlf['h'];
			} // 5.7.3
			else {
				$h = 0;
			}
			$this->bMargin = max($this->orig_bMargin, $this->margin_footer + $h + $this->autoMarginPadding);
			$this->PageBreakTrigger = $this->h - $this->bMargin;
		}
	}

	function _endpage()
	{
		/* -- CSS-IMAGE-FLOAT -- */
		$this->printfloatbuffer();
		/* -- END CSS-IMAGE-FLOAT -- */

		if ($this->visibility != 'visible')
			$this->SetVisibility('visible');
		$this->EndLayer();
		//End of page contents
		$this->state = 1;
	}

	function _newobj($obj_id = false, $onlynewobj = false)
	{
		if (!$obj_id) {
			$obj_id = ++$this->n;
		}
		//Begin a new object
		if (!$onlynewobj) {
			$this->offsets[$obj_id] = strlen($this->buffer);
			$this->_out($obj_id . ' 0 obj');
			$this->_current_obj_id = $obj_id; // for later use with encryption
		}
	}

	function _dounderline($x, $y, $txt, $OTLdata = false, $textvar = 0)
	{
		// Now print line exactly where $y secifies - called from Text() and Cell() - adjust  position there
		// WORD SPACING
		$w = ($this->GetStringWidth($txt, false, $OTLdata, $textvar) * _MPDFK) + ($this->charspacing * mb_strlen($txt, $this->mb_enc)) + ( $this->ws * mb_substr_count($txt, ' ', $this->mb_enc));
		//Draw a line
		return sprintf('%.3F %.3F m %.3F %.3F l S', $x * _MPDFK, ($this->h - $y) * _MPDFK, ($x * _MPDFK) + $w, ($this->h - $y) * _MPDFK);
	}

	function _imageError($file, $firsttime, $msg)
	{
		// Save re-trying image URL's which have already failed
		$this->failedimages[$file] = true;
		if ($firsttime && ($this->showImageErrors || $this->debug)) {
			throw new MpdfException("IMAGE Error (" . $file . "): " . $msg);
		}
		return false;
	}

	function _getImage(&$file, $firsttime = true, $allowvector = true, $orig_srcpath = false, $interpolation = false)
	{  // mPDF 6
		// firsttime i.e. whether to add to this->images - use false when calling iteratively
		// Image Data passed directly as var:varname
		if (preg_match('/var:\s*(.*)/', $file, $v)) {
			$data = $this->{$v[1]};
			$file = md5($data);
		}
		if (preg_match('/data:image\/(gif|jpeg|png);base64,(.*)/', $file, $v)) {
			$type = $v[1];
			$data = base64_decode($v[2]);
			$file = md5($data);
		}

		// mPDF 5.7.4 URLs
		if ($firsttime && $file && substr($file, 0, 5) != 'data:') {
			$file = str_replace(" ", "%20", $file);
		}
		if ($firsttime && $orig_srcpath) {
			// If orig_srcpath is a relative file path (and not a URL), then it needs to be URL decoded
			if (substr($orig_srcpath, 0, 5) != 'data:') {
				$orig_srcpath = str_replace(" ", "%20", $orig_srcpath);
			}
			if (!preg_match('/^(http|ftp)/', $orig_srcpath)) {
				$orig_srcpath = urldecode_parts($orig_srcpath);
			}
		}

		$ppUx = 0;
		if ($orig_srcpath && isset($this->images[$orig_srcpath])) {
			$file = $orig_srcpath;
			return $this->images[$orig_srcpath];
		}
		if (isset($this->images[$file])) {
			return $this->images[$file];
		} elseif ($orig_srcpath && isset($this->formobjects[$orig_srcpath])) {
			$file = $orig_srcpath;
			return $this->formobjects[$file];
		} elseif (isset($this->formobjects[$file])) {
			return $this->formobjects[$file];
		}
		// Save re-trying image URL's which have already failed
		elseif ($firsttime && isset($this->failedimages[$file])) {
			return $this->_imageError($file, $firsttime, '');
		}
		if (empty($data)) {
			$type = '';
			$data = '';

			if ($orig_srcpath && $this->basepathIsLocal && $check = @fopen($orig_srcpath, "rb")) {
				fclose($check);
				$file = $orig_srcpath;
				$data = file_get_contents($file);
				$type = $this->_imageTypeFromString($data);
			}
			if (!$data && $check = @fopen($file, "rb")) {
				fclose($check);
				$data = file_get_contents($file);
				$type = $this->_imageTypeFromString($data);
			}
			if ((!$data || !$type) && !ini_get('allow_url_fopen')) { // only worth trying if remote file and !ini_get('allow_url_fopen')
				$this->file_get_contents_by_socket($file, $data); // needs full url?? even on local (never needed for local)
				if ($data) {
					$type = $this->_imageTypeFromString($data);
				}
			}
			if ((!$data || !$type) && function_exists("curl_init")) { // mPDF 5.7.4
				$this->file_get_contents_by_curl($file, $data);  // needs full url?? even on local (never needed for local)
				if ($data) {
					$type = $this->_imageTypeFromString($data);
				}
			}
		}
		if (!$data) {
			return $this->_imageError($file, $firsttime, 'Could not find image file');
		}
		if (empty($type)) {
			$type = $this->_imageTypeFromString($data);
		}
		if (($type == 'wmf' || $type == 'svg') && !$allowvector) {
			return $this->_imageError($file, $firsttime, 'WMF or SVG image file not supported in this context');
		}

		// SVG
		if ($type == 'svg') {
			if (!class_exists('SVG', false)) {
				include(_MPDF_PATH . 'classes/svg.php');
			}
			$svg = new SVG($this);
			$family = $this->FontFamily;
			$style = $this->FontStyle;
			$size = $this->FontSizePt;
			$info = $svg->ImageSVG($data);
			//Restore font
			if ($family)
				$this->SetFont($family, $style, $size, false);
			if (!$info) {
				return $this->_imageError($file, $firsttime, 'Error parsing SVG file');
			}
			$info['type'] = 'svg';
			$info['i'] = count($this->formobjects) + 1;
			$this->formobjects[$file] = $info;
			return $info;
		}

		// JPEG
		if ($type == 'jpeg' || $type == 'jpg') {
			$hdr = $this->_jpgHeaderFromString($data);
			if (!$hdr) {
				return $this->_imageError($file, $firsttime, 'Error parsing JPG header');
			}
			$a = $this->_jpgDataFromHeader($hdr);
			$channels = intval($a[4]);
			$j = strpos($data, 'JFIF');
			if ($j) {
				//Read resolution
				$unitSp = ord(substr($data, ($j + 7), 1));
				if ($unitSp > 0) {
					$ppUx = $this->_twobytes2int(substr($data, ($j + 8), 2)); // horizontal pixels per meter, usually set to zero
					if ($unitSp == 2) { // = dots per cm (if == 1 set as dpi)
						$ppUx = round($ppUx / 10 * 25.4);
					}
				}
			}
			if ($a[2] == 'DeviceCMYK' && (($this->PDFA && $this->restrictColorSpace != 3) || $this->restrictColorSpace == 2)) {
				// convert to RGB image
				if (!function_exists("gd_info")) {
					throw new MpdfException("JPG image may not use CMYK color space (" . $file . ").");
				}
				if ($this->PDFA && !$this->PDFAauto) {
					$this->PDFAXwarnings[] = "JPG image may not use CMYK color space - " . $file . " - (Image converted to RGB. NB This will alter the colour profile of the image.)";
				}
				$im = @imagecreatefromstring($data);
				if ($im) {
					$tempfile = _MPDF_TEMP_PATH . '_tempImgPNG' . md5($file) . RAND(1, 10000) . '.png';
					imageinterlace($im, false);
					$check = @imagepng($im, $tempfile);
					if (!$check) {
						return $this->_imageError($file, $firsttime, 'Error creating temporary file (' . $tempfile . ') whilst using GD library to parse JPG(CMYK) image');
					}
					$info = $this->_getImage($tempfile, false);
					if (!$info) {
						return $this->_imageError($file, $firsttime, 'Error parsing temporary file (' . $tempfile . ') created with GD library to parse JPG(CMYK) image');
					}
					imagedestroy($im);
					unlink($tempfile);
					$info['type'] = 'jpg';
					if ($firsttime) {
						$info['i'] = count($this->images) + 1;
						$info['interpolation'] = $interpolation; // mPDF 6
						$this->images[$file] = $info;
					}
					return $info;
				} else {
					return $this->_imageError($file, $firsttime, 'Error creating GD image file from JPG(CMYK) image');
				}
			} elseif ($a[2] == 'DeviceRGB' && ($this->PDFX || $this->restrictColorSpace == 3)) {
				// Convert to CMYK image stream - nominally returned as type='png'
				$info = $this->_convImage($data, $a[2], 'DeviceCMYK', $a[0], $a[1], $ppUx, false);
				if (($this->PDFA && !$this->PDFAauto) || ($this->PDFX && !$this->PDFXauto)) {
					$this->PDFAXwarnings[] = "JPG image may not use RGB color space - " . $file . " - (Image converted to CMYK. NB This will alter the colour profile of the image.)";
				}
			} elseif (($a[2] == 'DeviceRGB' || $a[2] == 'DeviceCMYK') && $this->restrictColorSpace == 1) {
				// Convert to Grayscale image stream - nominally returned as type='png'
				$info = $this->_convImage($data, $a[2], 'DeviceGray', $a[0], $a[1], $ppUx, false);
			} else {

				// mPDF 6 Detect Adobe APP14 Tag
				//$pos = strpos($data, "\xFF\xEE\x00\x0EAdobe\0");
				//if ($pos !== false) {
				//}
				// mPDF 6 ICC profile
				$offset = 0;
				$icc = array();
				while (($pos = strpos($data, "ICC_PROFILE\0", $offset)) !== false) {
					// get ICC sequence length
					$length = $this->_twobytes2int(substr($data, ($pos - 2), 2)) - 16;
					$sn = max(1, ord($data[($pos + 12)]));
					$nom = max(1, ord($data[($pos + 13)]));
					$icc[($sn - 1)] = substr($data, ($pos + 14), $length);
					$offset = ($pos + 14 + $length);
				}
				// order and compact ICC segments
				if (count($icc) > 0) {
					ksort($icc);
					$icc = implode('', $icc);
					if (substr($icc, 36, 4) != 'acsp') {
						// invalid ICC profile
						$icc = false;
					}
					$input = substr($icc, 16, 4);
					$output = substr($icc, 20, 4);
					// Ignore Color profiles for conversion to other colorspaces e.g. CMYK/Lab
					if ($input != 'RGB ' || $output != 'XYZ ') {
						$icc = false;
					}
				} else {
					$icc = false;
				}

				$info = array('w' => $a[0], 'h' => $a[1], 'cs' => $a[2], 'bpc' => $a[3], 'f' => 'DCTDecode', 'data' => $data, 'type' => 'jpg', 'ch' => $channels, 'icc' => $icc);
				if ($ppUx) {
					$info['set-dpi'] = $ppUx;
				}
			}
			if (!$info) {
				return $this->_imageError($file, $firsttime, 'Error parsing or converting JPG image');
			}
			if ($firsttime) {
				$info['i'] = count($this->images) + 1;
				$info['interpolation'] = $interpolation; // mPDF 6
				$this->images[$file] = $info;
			}
			return $info;
		}

		// PNG
		elseif ($type == 'png') {
			//Check signature
			if (substr($data, 0, 8) != chr(137) . 'PNG' . chr(13) . chr(10) . chr(26) . chr(10)) {
				return $this->_imageError($file, $firsttime, 'Error parsing PNG identifier');
			}
			//Read header chunk
			if (substr($data, 12, 4) != 'IHDR') {
				return $this->_imageError($file, $firsttime, 'Incorrect PNG file (no IHDR block found)');
			}

			$w = $this->_fourbytes2int(substr($data, 16, 4));
			$h = $this->_fourbytes2int(substr($data, 20, 4));
			$bpc = ord(substr($data, 24, 1));
			$errpng = false;
			$pngalpha = false;
			$channels = 0;

			//	if($bpc>8) { $errpng = 'not 8-bit depth'; }	// mPDF 6 Allow through to be handled as native PNG

			$ct = ord(substr($data, 25, 1));
			if ($ct == 0) {
				$colspace = 'DeviceGray';
				$channels = 1;
			} elseif ($ct == 2) {
				$colspace = 'DeviceRGB';
				$channels = 3;
			} elseif ($ct == 3) {
				$colspace = 'Indexed';
				$channels = 1;
			} elseif ($ct == 4) {
				$colspace = 'DeviceGray';
				$channels = 1;
				$errpng = 'alpha channel';
				$pngalpha = true;
			} else {
				$colspace = 'DeviceRGB';
				$channels = 3;
				$errpng = 'alpha channel';
				$pngalpha = true;
			}

			if ($ct < 4 && strpos($data, 'tRNS') !== false) {
				$errpng = 'transparency';
				$pngalpha = true;
			} // mPDF 6

			if ($ct == 3 && strpos($data, 'iCCP') !== false) {
				$errpng = 'indexed plus ICC';
			} // mPDF 6
			// $pngalpha is used as a FLAG of any kind of transparency which COULD be tranferred to an alpha channel
			// incl. single-color tarnsparency, depending which type of handling occurs later

			if (ord(substr($data, 26, 1)) != 0) {
				$errpng = 'compression method';
			} // only 0 should be specified
			if (ord(substr($data, 27, 1)) != 0) {
				$errpng = 'filter method';
			}  // only 0 should be specified
			if (ord(substr($data, 28, 1)) != 0) {
				$errpng = 'interlaced file';
			}

			$j = strpos($data, 'pHYs');
			if ($j) {
				//Read resolution
				$unitSp = ord(substr($data, ($j + 12), 1));
				if ($unitSp == 1) {
					$ppUx = $this->_fourbytes2int(substr($data, ($j + 4), 4)); // horizontal pixels per meter, usually set to zero
					$ppUx = round($ppUx / 1000 * 25.4);
				}
			}

			// mPDF 6 Gamma correction
			$gamma_correction = 0;
			$gAMA = 0;
			$j = strpos($data, 'gAMA');
			if ($j && strpos($data, 'sRGB') === false) { // sRGB colorspace - overrides gAMA
				$gAMA = $this->_fourbytes2int(substr($data, ($j + 4), 4)); // Gamma value times 100000
				$gAMA /= 100000;

				// http://www.libpng.org/pub/png/spec/1.2/PNG-Encoders.html
				// "If the source file's gamma value is greater than 1.0, it is probably a display system exponent,..."
				// ("..and you should use its reciprocal for the PNG gamma.")
				//if ($gAMA > 1) { $gAMA = 1/$gAMA; }
				// (Some) Applications seem to ignore it... appearing how it was probably intended
				// Test Case - image(s) on http://www.w3.org/TR/CSS21/intro.html  - PNG has gAMA set as 1.45454
				// Probably unintentional as mentioned above and should be 0.45454 which is 1 / 2.2
				// Tested on Windows PC
				// Firefox and Opera display gray as 234 (correct, but looks wrong)
				// IE9 and Safari display gray as 193 (incorrect but looks right)
				// See test different gamma chunks at http://www.libpng.org/pub/png/pngsuite-all-good.html
			}

			if ($gAMA) {
				$gamma_correction = 1 / $gAMA;
			}

			// Don't need to apply gamma correction if == default i.e. 2.2
			if ($gamma_correction > 2.15 && $gamma_correction < 2.25) {
				$gamma_correction = 0;
			}

			// NOT supported at present
			//$j = strpos($data,'sRGB');	// sRGB colorspace - overrides gAMA
			//$j = strpos($data,'cHRM');	// Chromaticity and Whitepoint
			// $firsttime added mPDF 6 so when PNG Grayscale with alpha using resrtictcolorspace to CMYK
			// the alpha channel is sent through as secondtime as Indexed and should not be converted to CMYK
			if ($firsttime && ($colspace == 'DeviceRGB' || $colspace == 'Indexed') && ($this->PDFX || $this->restrictColorSpace == 3)) {
				// Convert to CMYK image stream - nominally returned as type='png'
				$info = $this->_convImage($data, $colspace, 'DeviceCMYK', $w, $h, $ppUx, $pngalpha, $gamma_correction, $ct); // mPDF 5.7.2 Gamma correction
				if (($this->PDFA && !$this->PDFAauto) || ($this->PDFX && !$this->PDFXauto)) {
					$this->PDFAXwarnings[] = "PNG image may not use RGB color space - " . $file . " - (Image converted to CMYK. NB This will alter the colour profile of the image.)";
				}
			}
			// $firsttime added mPDF 6 so when PNG Grayscale with alpha using resrtictcolorspace to CMYK
			// the alpha channel is sent through as secondtime as Indexed and should not be converted to CMYK
			elseif ($firsttime && ($colspace == 'DeviceRGB' || $colspace == 'Indexed') && $this->restrictColorSpace == 1) {
				// Convert to Grayscale image stream - nominally returned as type='png'
				$info = $this->_convImage($data, $colspace, 'DeviceGray', $w, $h, $ppUx, $pngalpha, $gamma_correction, $ct); // mPDF 5.7.2 Gamma correction
			} elseif (($this->PDFA || $this->PDFX) && $pngalpha) {

				// Remove alpha channel
				if ($this->restrictColorSpace == 1) { // Grayscale
					$info = $this->_convImage($data, $colspace, 'DeviceGray', $w, $h, $ppUx, $pngalpha, $gamma_correction, $ct); // mPDF 5.7.2 Gamma correction
				} elseif ($this->restrictColorSpace == 3) { // CMYK
					$info = $this->_convImage($data, $colspace, 'DeviceCMYK', $w, $h, $ppUx, $pngalpha, $gamma_correction, $ct); // mPDF 5.7.2 Gamma correction
				} elseif ($this->PDFA) { // RGB
					$info = $this->_convImage($data, $colspace, 'DeviceRGB', $w, $h, $ppUx, $pngalpha, $gamma_correction, $ct); // mPDF 5.7.2 Gamma correction
				}
				if (($this->PDFA && !$this->PDFAauto) || ($this->PDFX && !$this->PDFXauto)) {
					$this->PDFAXwarnings[] = "Transparency (alpha channel) not permitted in PDFA or PDFX files - " . $file . " - (Image converted to one without transparency.)";
				}
			} elseif ($firsttime && ($errpng || $pngalpha || $gamma_correction)) { // mPDF 5.7.2 Gamma correction
				if (function_exists('gd_info')) {
					$gd = gd_info();
				} else {
					$gd = array();
				}
				if (!isset($gd['PNG Support'])) {
					return $this->_imageError($file, $firsttime, 'GD library required for PNG image (' . $errpng . ')');
				}
				$im = imagecreatefromstring($data);

				if (!$im) {
					return $this->_imageError($file, $firsttime, 'Error creating GD image from PNG file (' . $errpng . ')');
				}
				$w = imagesx($im);
				$h = imagesy($im);
				if ($im) {
					$tempfile = _MPDF_TEMP_PATH . '_tempImgPNG' . md5($file) . RAND(1, 10000) . '.png';

					// Alpha channel set (including using tRNS for Paletted images)
					if ($pngalpha) {
						if ($this->PDFA) {
							throw new MpdfException("PDFA1-b does not permit images with alpha channel transparency (" . $file . ").");
						}

						$imgalpha = imagecreate($w, $h);
						// generate gray scale pallete
						for ($c = 0; $c < 256; ++$c) {
							imagecolorallocate($imgalpha, $c, $c, $c);
						}

						// mPDF 6
						if ($colspace == 'Indexed') { // generate Alpha channel values from tRNS
							//Read transparency info
							$transparency = '';
							$p = strpos($data, 'tRNS');
							if ($p) {
								$n = $this->_fourbytes2int(substr($data, ($p - 4), 4));
								$transparency = substr($data, ($p + 4), $n);
								// ord($transparency{$index}) = the alpha value for that index
								// generate alpha channel
								for ($ypx = 0; $ypx < $h; ++$ypx) {
									for ($xpx = 0; $xpx < $w; ++$xpx) {
										$colorindex = imagecolorat($im, $xpx, $ypx);
										if ($colorindex >= $n) {
											$alpha = 255;
										} else {
											$alpha = ord($transparency{$colorindex});
										} // 0-255
										if ($alpha > 0) {
											imagesetpixel($imgalpha, $xpx, $ypx, $alpha);
										}
									}
								}
							}
						} elseif ($ct === 0 || $ct == 2) { // generate Alpha channel values from tRNS
							// Get transparency as array of RGB
							$p = strpos($data, 'tRNS');
							if ($p) {
								$trns = '';
								$n = $this->_fourbytes2int(substr($data, ($p - 4), 4));
								$t = substr($data, ($p + 4), $n);
								if ($colspace == 'DeviceGray') {  // ct===0
									$trns = array($this->_trnsvalue(substr($t, 0, 2), $bpc));
								} else /* $colspace=='DeviceRGB' */ {  // ct==2
									$trns = array();
									$trns[0] = $this->_trnsvalue(substr($t, 0, 2), $bpc);
									$trns[1] = $this->_trnsvalue(substr($t, 2, 2), $bpc);
									$trns[2] = $this->_trnsvalue(substr($t, 4, 2), $bpc);
								}

								// generate alpha channel
								for ($ypx = 0; $ypx < $h; ++$ypx) {
									for ($xpx = 0; $xpx < $w; ++$xpx) {
										$rgb = imagecolorat($im, $xpx, $ypx);
										$r = ($rgb >> 16) & 0xFF;
										$g = ($rgb >> 8) & 0xFF;
										$b = $rgb & 0xFF;
										if ($colspace == 'DeviceGray' && $b == $trns[0]) {
											$alpha = 0;
										} elseif ($r == $trns[0] && $g == $trns[1] && $b == $trns[2]) {
											$alpha = 0;
										}  // ct==2
										else {
											$alpha = 255;
										}
										if ($alpha > 0) {
											imagesetpixel($imgalpha, $xpx, $ypx, $alpha);
										}
									}
								}
							}
						} else {
							// extract alpha channel
							for ($ypx = 0; $ypx < $h; ++$ypx) {
								for ($xpx = 0; $xpx < $w; ++$xpx) {
									$alpha = (imagecolorat($im, $xpx, $ypx) & 0x7F000000) >> 24;
									if ($alpha < 127) {
										imagesetpixel($imgalpha, $xpx, $ypx, (255 - ($alpha * 2)));
									}
								}
							}
						}


						// NB This must happen after the Alpha channel is extracted
						// imagegammacorrect() removes the alpha channel data in $im - (I think this is a bug in PHP)
						if ($gamma_correction) {
							imagegammacorrect($im, $gamma_correction, 2.2);
						} // mPDF 6 Gamma correction
						// create temp alpha file
						$tempfile_alpha = _MPDF_TEMP_PATH . '_tempMskPNG' . md5($file) . RAND(1, 10000) . '.png';
						if (!is_writable(_MPDF_TEMP_PATH)) {  // mPDF 5.7.2
							ob_start();
							$check = @imagepng($imgalpha);
							if (!$check) {
								return $this->_imageError($file, $firsttime, 'Error creating temporary image object whilst using GD library to parse PNG image');
							}
							imagedestroy($imgalpha);
							$this->_tempimg = ob_get_contents();
							$this->_tempimglnk = 'var:_tempimg';
							ob_end_clean();
							// extract image without alpha channel
							$imgplain = imagecreatetruecolor($w, $h);
							imagealphablending($imgplain, false); // mPDF 5.7.2
							imagecopy($imgplain, $im, 0, 0, 0, 0, $w, $h);
							// create temp image file
							$minfo = $this->_getImage($this->_tempimglnk, false);
							if (!$minfo) {
								return $this->_imageError($file, $firsttime, 'Error parsing temporary file image object created with GD library to parse PNG image');
							}
							ob_start();
							$check = @imagepng($imgplain);
							if (!$check) {
								return $this->_imageError($file, $firsttime, 'Error creating temporary image object whilst using GD library to parse PNG image');
							}
							$this->_tempimg = ob_get_contents();
							$this->_tempimglnk = 'var:_tempimg';
							ob_end_clean();
							$info = $this->_getImage($this->_tempimglnk, false);
							if (!$info) {
								return $this->_imageError($file, $firsttime, 'Error parsing temporary file image object created with GD library to parse PNG image');
							}
							imagedestroy($imgplain);
							$imgmask = count($this->images) + 1;
							$minfo['cs'] = 'DeviceGray';
							$minfo['i'] = $imgmask;
							$this->images[$tempfile_alpha] = $minfo;
						} else {
							$check = @imagepng($imgalpha, $tempfile_alpha);
							if (!$check) {
								return $this->_imageError($file, $firsttime, 'Failed to create temporary image file (' . $tempfile_alpha . ') parsing PNG image with alpha channel (' . $errpng . ')');
							}
							imagedestroy($imgalpha);
							// extract image without alpha channel
							$imgplain = imagecreatetruecolor($w, $h);
							imagealphablending($imgplain, false); // mPDF 5.7.2
							imagecopy($imgplain, $im, 0, 0, 0, 0, $w, $h);

							// create temp image file
							$check = @imagepng($imgplain, $tempfile);
							if (!$check) {
								return $this->_imageError($file, $firsttime, 'Failed to create temporary image file (' . $tempfile . ') parsing PNG image with alpha channel (' . $errpng . ')');
							}
							imagedestroy($imgplain);
							// embed mask image
							$minfo = $this->_getImage($tempfile_alpha, false);
							unlink($tempfile_alpha);
							if (!$minfo) {
								return $this->_imageError($file, $firsttime, 'Error parsing temporary file (' . $tempfile_alpha . ') created with GD library to parse PNG image');
							}
							$imgmask = count($this->images) + 1;
							$minfo['cs'] = 'DeviceGray';
							$minfo['i'] = $imgmask;
							$this->images[$tempfile_alpha] = $minfo;
							// embed image, masked with previously embedded mask
							$info = $this->_getImage($tempfile, false);
							unlink($tempfile);
							if (!$info) {
								return $this->_imageError($file, $firsttime, 'Error parsing temporary file (' . $tempfile . ') created with GD library to parse PNG image');
							}
						}
						$info['masked'] = $imgmask;
						if ($ppUx) {
							$info['set-dpi'] = $ppUx;
						}
						$info['type'] = 'png';
						if ($firsttime) {
							$info['i'] = count($this->images) + 1;
							$info['interpolation'] = $interpolation; // mPDF 6
							$this->images[$file] = $info;
						}

						return $info;
					} else {  // No alpha/transparency set (but cannot read directly because e.g. bit-depth != 8, interlaced etc)
						// ICC profile
						$icc = false;
						$p = strpos($data, 'iCCP');
						if ($p && $colspace == "Indexed") { // Cannot have ICC profile and Indexed together
							$p += 4;
							$n = $this->_fourbytes2int(substr($data, ($p - 8), 4));
							$nullsep = strpos(substr($data, $p, 80), chr(0));
							$icc = substr($data, ($p + $nullsep + 2), ($n - ($nullsep + 2)));
							$icc = @gzuncompress($icc); // Ignored if fails
							if ($icc) {
								if (substr($icc, 36, 4) != 'acsp') {
									$icc = false;
								} // invalid ICC profile
								else {
									$input = substr($icc, 16, 4);
									$output = substr($icc, 20, 4);
									// Ignore Color profiles for conversion to other colorspaces e.g. CMYK/Lab
									if ($input != 'RGB ' || $output != 'XYZ ') {
										$icc = false;
									}
								}
							}
							// Convert to RGB colorspace so can use ICC Profile
							if ($icc) {
								imagepalettetotruecolor($im);
								$colspace = 'DeviceRGB';
								$channels = 3;
							}
						}

						if ($gamma_correction) {
							imagegammacorrect($im, $gamma_correction, 2.2);
						} // mPDF 6 Gamma correction
						imagealphablending($im, false);
						imagesavealpha($im, false);
						imageinterlace($im, false);
						if (!is_writable(_MPDF_TEMP_PATH)) {  // mPDF 5.7.2
							ob_start();
							$check = @imagepng($im);
							if (!$check) {
								return $this->_imageError($file, $firsttime, 'Error creating temporary image object whilst using GD library to parse PNG image');
							}
							$this->_tempimg = ob_get_contents();
							$this->_tempimglnk = 'var:_tempimg';
							ob_end_clean();
							$info = $this->_getImage($this->_tempimglnk, false);
							if (!$info) {
								return $this->_imageError($file, $firsttime, 'Error parsing temporary file image object created with GD library to parse PNG image');
							}
							imagedestroy($im);
						} else {
							$check = @imagepng($im, $tempfile);
							if (!$check) {
								return $this->_imageError($file, $firsttime, 'Failed to create temporary image file (' . $tempfile . ') parsing PNG image (' . $errpng . ')');
							}
							imagedestroy($im);
							$info = $this->_getImage($tempfile, false);
							unlink($tempfile);
							if (!$info) {
								return $this->_imageError($file, $firsttime, 'Error parsing temporary file (' . $tempfile . ') created with GD library to parse PNG image');
							}
						}
						if ($ppUx) {
							$info['set-dpi'] = $ppUx;
						}
						$info['type'] = 'png';
						if ($firsttime) {
							$info['i'] = count($this->images) + 1;
							$info['interpolation'] = $interpolation; // mPDF 6
							if ($icc) {
								$info['ch'] = $channels;
								$info['icc'] = $icc;
							}
							$this->images[$file] = $info;
						}
						return $info;
					}
				}
			} else { // PNG image with no need to convert alph channels, bpc <> 8 etc.
				$parms = '/DecodeParms <</Predictor 15 /Colors ' . $channels . ' /BitsPerComponent ' . $bpc . ' /Columns ' . $w . '>>';
				//Scan chunks looking for palette, transparency and image data
				$pal = '';
				$trns = '';
				$pngdata = '';
				$icc = false;
				$p = 33;
				do {
					$n = $this->_fourbytes2int(substr($data, $p, 4));
					$p += 4;
					$type = substr($data, $p, 4);
					$p += 4;
					if ($type == 'PLTE') {
						//Read palette
						$pal = substr($data, $p, $n);
						$p += $n;
						$p += 4;
					} elseif ($type == 'tRNS') {
						//Read transparency info
						$t = substr($data, $p, $n);
						$p += $n;
						if ($ct == 0)
							$trns = array(ord(substr($t, 1, 1)));
						elseif ($ct == 2)
							$trns = array(ord(substr($t, 1, 1)), ord(substr($t, 3, 1)), ord(substr($t, 5, 1)));
						else {
							$pos = strpos($t, chr(0));
							if (is_int($pos))
								$trns = array($pos);
						}
						$p += 4;
					}
					elseif ($type == 'IDAT') {
						$pngdata.=substr($data, $p, $n);
						$p += $n;
						$p += 4;
					} elseif ($type == 'iCCP') {
						$nullsep = strpos(substr($data, $p, 80), chr(0));
						$icc = substr($data, ($p + $nullsep + 2), ($n - ($nullsep + 2)));
						$icc = @gzuncompress($icc); // Ignored if fails
						if ($icc) {
							if (substr($icc, 36, 4) != 'acsp') {
								$icc = false;
							} // invalid ICC profile
							else {
								$input = substr($icc, 16, 4);
								$output = substr($icc, 20, 4);
								// Ignore Color profiles for conversion to other colorspaces e.g. CMYK/Lab
								if ($input != 'RGB ' || $output != 'XYZ ') {
									$icc = false;
								}
							}
						}
						$p += $n;
						$p += 4;
					} elseif ($type == 'IEND') {
						break;
					} elseif (preg_match('/[a-zA-Z]{4}/', $type)) {
						$p += $n + 4;
					} else {
						return $this->_imageError($file, $firsttime, 'Error parsing PNG image data');
					}
				} while ($n);
				if (!$pngdata) {
					return $this->_imageError($file, $firsttime, 'Error parsing PNG image data - no IDAT data found');
				}
				if ($colspace == 'Indexed' && empty($pal)) {
					return $this->_imageError($file, $firsttime, 'Error parsing PNG image data - missing colour palette');
				}

				if ($colspace == 'Indexed' && $icc) {
					$icc = false;
				} // mPDF 6 cannot have ICC profile and Indexed in a PDF document as both use the colorspace tag.

				$info = array('w' => $w, 'h' => $h, 'cs' => $colspace, 'bpc' => $bpc, 'f' => 'FlateDecode', 'parms' => $parms, 'pal' => $pal, 'trns' => $trns, 'data' => $pngdata, 'ch' => $channels, 'icc' => $icc);
				$info['type'] = 'png';
				if ($ppUx) {
					$info['set-dpi'] = $ppUx;
				}
			}

			if (!$info) {
				return $this->_imageError($file, $firsttime, 'Error parsing or converting PNG image');
			}

			if ($firsttime) {
				$info['i'] = count($this->images) + 1;
				$info['interpolation'] = $interpolation; // mPDF 6
				$this->images[$file] = $info;
			}
			return $info;
		}

		// GIF
		elseif ($type == 'gif') {
			if (function_exists('gd_info')) {
				$gd = gd_info();
			} else {
				$gd = array();
			}
			if (isset($gd['GIF Read Support']) && $gd['GIF Read Support']) {
				$im = @imagecreatefromstring($data);
				if ($im) {
					$tempfile = _MPDF_TEMP_PATH . '_tempImgPNG' . md5($file) . RAND(1, 10000) . '.png';
					imagealphablending($im, false);
					imagesavealpha($im, false);
					imageinterlace($im, false);
					if (!is_writable($tempfile)) {
						ob_start();
						$check = @imagepng($im);
						if (!$check) {
							return $this->_imageError($file, $firsttime, 'Error creating temporary image object whilst using GD library to parse GIF image');
						}
						$this->_tempimg = ob_get_contents();
						$this->_tempimglnk = 'var:_tempimg';
						ob_end_clean();
						$info = $this->_getImage($this->_tempimglnk, false);
						if (!$info) {
							return $this->_imageError($file, $firsttime, 'Error parsing temporary file image object created with GD library to parse GIF image');
						}
						imagedestroy($im);
					} else {
						$check = @imagepng($im, $tempfile);
						if (!$check) {
							return $this->_imageError($file, $firsttime, 'Error creating temporary file (' . $tempfile . ') whilst using GD library to parse GIF image');
						}
						$info = $this->_getImage($tempfile, false);
						if (!$info) {
							return $this->_imageError($file, $firsttime, 'Error parsing temporary file (' . $tempfile . ') created with GD library to parse GIF image');
						}
						imagedestroy($im);
						unlink($tempfile);
					}
					$info['type'] = 'gif';
					if ($firsttime) {
						$info['i'] = count($this->images) + 1;
						$info['interpolation'] = $interpolation; // mPDF 6
						$this->images[$file] = $info;
					}
					return $info;
				} else {
					return $this->_imageError($file, $firsttime, 'Error creating GD image file from GIF image');
				}
			}

			if (!class_exists('gif', false)) {
				include_once(_MPDF_PATH . 'classes/gif.php');
			}
			$gif = new CGIF();

			$h = 0;
			$w = 0;
			$gif->loadFile($data, 0);

			if (isset($gif->m_img->m_gih->m_bLocalClr) && $gif->m_img->m_gih->m_bLocalClr) {
				$nColors = $gif->m_img->m_gih->m_nTableSize;
				$pal = $gif->m_img->m_gih->m_colorTable->toString();
				if ((isset($bgColor)) and $bgColor != -1) { // mPDF 5.7.3
					$bgColor = $gif->m_img->m_gih->m_colorTable->colorIndex($bgColor);
				}
				$colspace = 'Indexed';
			} elseif (isset($gif->m_gfh->m_bGlobalClr) && $gif->m_gfh->m_bGlobalClr) {
				$nColors = $gif->m_gfh->m_nTableSize;
				$pal = $gif->m_gfh->m_colorTable->toString();
				if ((isset($bgColor)) and $bgColor != -1) {
					$bgColor = $gif->m_gfh->m_colorTable->colorIndex($bgColor);
				}
				$colspace = 'Indexed';
			} else {
				$nColors = 0;
				$bgColor = -1;
				$colspace = 'DeviceGray';
				$pal = '';
			}

			$trns = '';
			if (isset($gif->m_img->m_bTrans) && $gif->m_img->m_bTrans && ($nColors > 0)) {
				$trns = array($gif->m_img->m_nTrans);
			}
			$gifdata = $gif->m_img->m_data;
			$w = $gif->m_gfh->m_nWidth;
			$h = $gif->m_gfh->m_nHeight;
			$gif->ClearData();

			if ($colspace == 'Indexed' and empty($pal)) {
				return $this->_imageError($file, $firsttime, 'Error parsing GIF image - missing colour palette');
			}
			if ($this->compress) {
				$gifdata = gzcompress($gifdata);
				$info = array('w' => $w, 'h' => $h, 'cs' => $colspace, 'bpc' => 8, 'f' => 'FlateDecode', 'pal' => $pal, 'trns' => $trns, 'data' => $gifdata);
			} else {
				$info = array('w' => $w, 'h' => $h, 'cs' => $colspace, 'bpc' => 8, 'pal' => $pal, 'trns' => $trns, 'data' => $gifdata);
			}
			$info['type'] = 'gif';
			if ($firsttime) {
				$info['i'] = count($this->images) + 1;
				$info['interpolation'] = $interpolation; // mPDF 6
				$this->images[$file] = $info;
			}
			return $info;
		}

		/* -- IMAGES-BMP -- */
		// BMP (Windows Bitmap)
		elseif ($type == 'bmp') {
			if (!class_exists('bmp', false)) {
				include(_MPDF_PATH . 'classes/bmp.php');
			}
			if (empty($this->bmp)) {
				$this->bmp = new bmp($this);
			}
			$info = $this->bmp->_getBMPimage($data, $file);
			if (isset($info['error'])) {
				return $this->_imageError($file, $firsttime, $info['error']);
			}
			if ($firsttime) {
				$info['i'] = count($this->images) + 1;
				$info['interpolation'] = $interpolation; // mPDF 6
				$this->images[$file] = $info;
			}
			return $info;
		}
		/* -- END IMAGES-BMP -- */
		/* -- IMAGES-WMF -- */
		// WMF
		elseif ($type == 'wmf') {
			if (!class_exists('wmf', false)) {
				include(_MPDF_PATH . 'classes/wmf.php');
			}
			if (empty($this->wmf)) {
				$this->wmf = new wmf($this);
			}
			$wmfres = $this->wmf->_getWMFimage($data);
			if ($wmfres[0] == 0) {
				if ($wmfres[1]) {
					return $this->_imageError($file, $firsttime, $wmfres[1]);
				}
				return $this->_imageError($file, $firsttime, 'Error parsing WMF image');
			}
			$info = array('x' => $wmfres[2][0], 'y' => $wmfres[2][1], 'w' => $wmfres[3][0], 'h' => $wmfres[3][1], 'data' => $wmfres[1]);
			$info['i'] = count($this->formobjects) + 1;
			$info['type'] = 'wmf';
			$this->formobjects[$file] = $info;
			return $info;
		}
		/* -- END IMAGES-WMF -- */

		// UNKNOWN TYPE - try GD imagecreatefromstring
		else {
			if (function_exists('gd_info')) {
				$gd = gd_info();
			} else {
				$gd = array();
			}
			if (isset($gd['PNG Support']) && $gd['PNG Support']) {
				$im = @imagecreatefromstring($data);
				if (!$im) {
					return $this->_imageError($file, $firsttime, 'Error parsing image file - image type not recognised, and not supported by GD imagecreate');
				}
				$tempfile = _MPDF_TEMP_PATH . '_tempImgPNG' . md5($file) . RAND(1, 10000) . '.png';
				imagealphablending($im, false);
				imagesavealpha($im, false);
				imageinterlace($im, false);
				$check = @imagepng($im, $tempfile);
				if (!$check) {
					return $this->_imageError($file, $firsttime, 'Error creating temporary file (' . $tempfile . ') whilst using GD library to parse unknown image type');
				}
				$info = $this->_getImage($tempfile, false);
				imagedestroy($im);
				unlink($tempfile);
				if (!$info) {
					return $this->_imageError($file, $firsttime, 'Error parsing temporary file (' . $tempfile . ') created with GD library to parse unknown image type');
				}
				$info['type'] = 'png';
				if ($firsttime) {
					$info['i'] = count($this->images) + 1;
					$info['interpolation'] = $interpolation; // mPDF 6
					$this->images[$file] = $info;
				}
				return $info;
			}
		}

		return $this->_imageError($file, $firsttime, 'Error parsing image file - image type not recognised');
	}

	//==============================================================
	function _convImage(&$data, $colspace, $targetcs, $w, $h, $dpi, $mask, $gamma_correction = false, $pngcolortype = false)
	{ // mPDF 5.7.2 Gamma correction
		if ($this->PDFA || $this->PDFX) {
			$mask = false;
		}
		$im = @imagecreatefromstring($data);
		$info = array();
		$bpc = ord(substr($data, 24, 1));
		if ($im) {

			$imgdata = '';
			$mimgdata = '';
			$minfo = array();

			// mPDF 6 Gamma correction
			// Need to extract alpha channel info before imagegammacorrect (which loses the data)
			if ($mask) { // i.e. $pngalpha for PNG
				// mPDF 6
				if ($colspace == 'Indexed') { // generate Alpha channel values from tRNS - only from PNG
					//Read transparency info
					$transparency = '';
					$p = strpos($data, 'tRNS');
					if ($p) {
						$n = $this->_fourbytes2int(substr($data, ($p - 4), 4));
						$transparency = substr($data, ($p + 4), $n);
						// ord($transparency{$index}) = the alpha value for that index
						// generate alpha channel
						for ($ypx = 0; $ypx < $h; ++$ypx) {
							for ($xpx = 0; $xpx < $w; ++$xpx) {
								$colorindex = imagecolorat($im, $xpx, $ypx);
								if ($colorindex >= $n) {
									$alpha = 255;
								} else {
									$alpha = ord($transparency{$colorindex});
								} // 0-255
								$mimgdata .= chr($alpha);
							}
						}
					}
				} elseif ($pngcolortype === 0 || $pngcolortype == 2) { // generate Alpha channel values from tRNS
					// Get transparency as array of RGB
					$p = strpos($data, 'tRNS');
					if ($p) {
						$trns = '';
						$n = $this->_fourbytes2int(substr($data, ($p - 4), 4));
						$t = substr($data, ($p + 4), $n);
						if ($colspace == 'DeviceGray') {  // ct===0
							$trns = array($this->_trnsvalue(substr($t, 0, 2), $bpc));
						} else /* $colspace=='DeviceRGB' */ {  // ct==2
							$trns = array();
							$trns[0] = $this->_trnsvalue(substr($t, 0, 2), $bpc);
							$trns[1] = $this->_trnsvalue(substr($t, 2, 2), $bpc);
							$trns[2] = $this->_trnsvalue(substr($t, 4, 2), $bpc);
						}

						// generate alpha channel
						for ($ypx = 0; $ypx < $h; ++$ypx) {
							for ($xpx = 0; $xpx < $w; ++$xpx) {
								$rgb = imagecolorat($im, $xpx, $ypx);
								$r = ($rgb >> 16) & 0xFF;
								$g = ($rgb >> 8) & 0xFF;
								$b = $rgb & 0xFF;
								if ($colspace == 'DeviceGray' && $b == $trns[0]) {
									$alpha = 0;
								} elseif ($r == $trns[0] && $g == $trns[1] && $b == $trns[2]) {
									$alpha = 0;
								}  // ct==2
								else {
									$alpha = 255;
								}
								$mimgdata .= chr($alpha);
							}
						}
					}
				} else {
					for ($i = 0; $i < $h; $i++) {
						for ($j = 0; $j < $w; $j++) {
							$rgb = imagecolorat($im, $j, $i);
							$alpha = ($rgb & 0x7F000000) >> 24;
							if ($alpha < 127) {
								$mimgdata .= chr(255 - ($alpha * 2));
							} else {
								$mimgdata .= chr(0);
							}
						}
					}
				}
			}

			if ($gamma_correction) {
				imagegammacorrect($im, $gamma_correction, 2.2);
			} // mPDF 6 Gamma correction
			//Read transparency info
			$trns = array();
			$trnsrgb = false;
			if (!$this->PDFA && !$this->PDFX && !$mask) {  // mPDF 6 added NOT mask
				$p = strpos($data, 'tRNS');
				if ($p) {
					$n = $this->_fourbytes2int(substr($data, ($p - 4), 4));
					$t = substr($data, ($p + 4), $n);
					if ($colspace == 'DeviceGray') {  // ct===0
						$trns = array($this->_trnsvalue(substr($t, 0, 2), $bpc));
					} elseif ($colspace == 'DeviceRGB') {  // ct==2
						$trns[0] = $this->_trnsvalue(substr($t, 0, 2), $bpc);
						$trns[1] = $this->_trnsvalue(substr($t, 2, 2), $bpc);
						$trns[2] = $this->_trnsvalue(substr($t, 4, 2), $bpc);
						$trnsrgb = $trns;
						if ($targetcs == 'DeviceCMYK') {
							$col = $this->rgb2cmyk(array(3, $trns[0], $trns[1], $trns[2]));
							$c1 = intval($col[1] * 2.55);
							$c2 = intval($col[2] * 2.55);
							$c3 = intval($col[3] * 2.55);
							$c4 = intval($col[4] * 2.55);
							$trns = array($c1, $c2, $c3, $c4);
						} elseif ($targetcs == 'DeviceGray') {
							$c = intval(($trns[0] * .21) + ($trns[1] * .71) + ($trns[2] * .07));
							$trns = array($c);
						}
					} else { // Indexed
						$pos = strpos($t, chr(0));
						if (is_int($pos)) {
							$pal = imagecolorsforindex($im, $pos);
							$r = $pal['red'];
							$g = $pal['green'];
							$b = $pal['blue'];
							$trns = array($r, $g, $b); // ****
							$trnsrgb = $trns;
							if ($targetcs == 'DeviceCMYK') {
								$col = $this->rgb2cmyk(array(3, $r, $g, $b));
								$c1 = intval($col[1] * 2.55);
								$c2 = intval($col[2] * 2.55);
								$c3 = intval($col[3] * 2.55);
								$c4 = intval($col[4] * 2.55);
								$trns = array($c1, $c2, $c3, $c4);
							} elseif ($targetcs == 'DeviceGray') {
								$c = intval(($r * .21) + ($g * .71) + ($b * .07));
								$trns = array($c);
							}
						}
					}
				}
			}
			for ($i = 0; $i < $h; $i++) {
				for ($j = 0; $j < $w; $j++) {
					$rgb = imagecolorat($im, $j, $i);
					$r = ($rgb >> 16) & 0xFF;
					$g = ($rgb >> 8) & 0xFF;
					$b = $rgb & 0xFF;
					if ($colspace == 'Indexed') {
						$pal = imagecolorsforindex($im, $rgb);
						$r = $pal['red'];
						$g = $pal['green'];
						$b = $pal['blue'];
					}

					if ($targetcs == 'DeviceCMYK') {
						$col = $this->rgb2cmyk(array(3, $r, $g, $b));
						$c1 = intval($col[1] * 2.55);
						$c2 = intval($col[2] * 2.55);
						$c3 = intval($col[3] * 2.55);
						$c4 = intval($col[4] * 2.55);
						if ($trnsrgb) {
							// original pixel was not set as transparent but processed color does match
							if ($trnsrgb != array($r, $g, $b) && $trns == array($c1, $c2, $c3, $c4)) {
								if ($c4 == 0) {
									$c4 = 1;
								} else {
									$c4--;
								}
							}
						}
						$imgdata .= chr($c1) . chr($c2) . chr($c3) . chr($c4);
					} elseif ($targetcs == 'DeviceGray') {
						$c = intval(($r * .21) + ($g * .71) + ($b * .07));
						if ($trnsrgb) {
							// original pixel was not set as transparent but processed color does match
							if ($trnsrgb != array($r, $g, $b) && $trns == array($c)) {
								if ($c == 0) {
									$c = 1;
								} else {
									$c--;
								}
							}
						}
						$imgdata .= chr($c);
					} elseif ($targetcs == 'DeviceRGB') {
						$imgdata .= chr($r) . chr($g) . chr($b);
					}
				}
			}

			if ($targetcs == 'DeviceGray') {
				$ncols = 1;
			} elseif ($targetcs == 'DeviceRGB') {
				$ncols = 3;
			} elseif ($targetcs == 'DeviceCMYK') {
				$ncols = 4;
			}

			$imgdata = gzcompress($imgdata);
			$info = array('w' => $w, 'h' => $h, 'cs' => $targetcs, 'bpc' => 8, 'f' => 'FlateDecode', 'data' => $imgdata, 'type' => 'png',
				'parms' => '/DecodeParms <</Colors ' . $ncols . ' /BitsPerComponent 8 /Columns ' . $w . '>>');
			if ($dpi) {
				$info['set-dpi'] = $dpi;
			}
			if ($mask) {
				$mimgdata = gzcompress($mimgdata);
				$minfo = array('w' => $w, 'h' => $h, 'cs' => 'DeviceGray', 'bpc' => 8, 'f' => 'FlateDecode', 'data' => $mimgdata, 'type' => 'png',
					'parms' => '/DecodeParms <</Colors ' . $ncols . ' /BitsPerComponent 8 /Columns ' . $w . '>>');
				if ($dpi) {
					$minfo['set-dpi'] = $dpi;
				}
				$tempfile = '_tempImgPNG' . md5($data) . RAND(1, 10000) . '.png';
				$imgmask = count($this->images) + 1;
				$minfo['i'] = $imgmask;
				$this->images[$tempfile] = $minfo;
				$info['masked'] = $imgmask;
			} elseif ($trns) {
				$info['trns'] = $trns;
			}
			imagedestroy($im);
		}
		return $info;
	}

	function _trnsvalue($s, $bpc)
	{
		// Corrects 2-byte integer to 8-bit depth value
		// If original image is bpc != 8, tRNS will be in this bpc
		// $im from imagecreatefromstring will always be in bpc=8
		// So why do we only need to correct 16-bit tRNS and NOT 2 or 4-bit???
		$n = $this->_twobytes2int($s);
		if ($bpc == 16) {
			$n = ($n >> 8);
		}
		//elseif ($bpc==4) { $n = ($n << 2); }
		//elseif ($bpc==2) { $n = ($n << 4); }
		return $n;
	}

	function _fourbytes2int($s)
	{
		//Read a 4-byte integer from string
		return (ord($s[0]) << 24) + (ord($s[1]) << 16) + (ord($s[2]) << 8) + ord($s[3]);
	}

	function _twobytes2int($s)
	{ // equivalent to _get_ushort
		//Read a 2-byte integer from string
		return (ord(substr($s, 0, 1)) << 8) + ord(substr($s, 1, 1));
	}

	function _jpgHeaderFromString(&$data)
	{
		$p = 4;
		$p += $this->_twobytes2int(substr($data, $p, 2)); // Length of initial marker block
		$marker = substr($data, $p, 2);
		while ($marker != chr(255) . chr(192) && $marker != chr(255) . chr(194) && $p < strlen($data)) {
			// Start of frame marker (FFC0) or (FFC2) mPDF 4.4.004
			$p += ($this->_twobytes2int(substr($data, $p + 2, 2))) + 2; // Length of marker block
			$marker = substr($data, $p, 2);
		}
		if ($marker != chr(255) . chr(192) && $marker != chr(255) . chr(194)) {
			return false;
		}
		return substr($data, $p + 2, 10);
	}

	function _jpgDataFromHeader($hdr)
	{
		$bpc = ord(substr($hdr, 2, 1));
		if (!$bpc) {
			$bpc = 8;
		}
		$h = $this->_twobytes2int(substr($hdr, 3, 2));
		$w = $this->_twobytes2int(substr($hdr, 5, 2));
		$channels = ord(substr($hdr, 7, 1));
		if ($channels == 3) {
			$colspace = 'DeviceRGB';
		} elseif ($channels == 4) {
			$colspace = 'DeviceCMYK';
		} else {
			$colspace = 'DeviceGray';
		}
		return array($w, $h, $colspace, $bpc, $channels);
	}

	function file_get_contents_by_curl($url, &$data)
	{
		$timeout = 5;
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:13.0) Gecko/20100101 Firefox/13.0.1'); // mPDF 5.7.4
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_NOBODY, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
		$data = curl_exec($ch);
		curl_close($ch);
	}

	function file_get_contents_by_socket($url, &$data)
	{
		// mPDF 5.7.3
		$timeout = 1;
		$p = parse_url($url);
		$file = $p['path'];
		if ($p['scheme'] == 'https') {
			$prefix = 'ssl://';
			$port = ($p['port'] ? $p['port'] : 443);
		} else {
			$prefix = '';
			$port = ($p['port'] ? $p['port'] : 80);
		}
		if ($p['query']) {
			$file .= '?' . $p['query'];
		}
		if (!($fh = @fsockopen($prefix . $p['host'], $port, $errno, $errstr, $timeout))) {
			return false;
		}

		$getstring = "GET " . $file . " HTTP/1.0 \r\n" .
			"Host: " . $p['host'] . " \r\n" .
			"Connection: close\r\n\r\n";
		fwrite($fh, $getstring);
		// Get rid of HTTP header
		$s = fgets($fh, 1024);
		if (!$s) {
			return false;
		}
		$httpheader .= $s;
		while (!feof($fh)) {
			$s = fgets($fh, 1024);
			if ($s == "\r\n") {
				break;
			}
		}
		$data = '';
		while (!feof($fh)) {
			$data .= fgets($fh, 1024);
		}
		fclose($fh);
	}

	//==============================================================

	function _imageTypeFromString(&$data)
	{
		$type = '';
		if (substr($data, 6, 4) == 'JFIF' || substr($data, 6, 4) == 'Exif' || substr($data, 0, 2) == chr(255) . chr(216)) { // 0xFF 0xD8	// mpDF 5.7.2
			$type = 'jpeg';
		} elseif (substr($data, 0, 6) == "GIF87a" || substr($data, 0, 6) == "GIF89a") {
			$type = 'gif';
		} elseif (substr($data, 0, 8) == chr(137) . 'PNG' . chr(13) . chr(10) . chr(26) . chr(10)) {
			$type = 'png';
		}
		/* -- IMAGES-WMF -- */ elseif (substr($data, 0, 4) == chr(215) . chr(205) . chr(198) . chr(154)) {
			$type = 'wmf';
		}
		/* -- END IMAGES-WMF -- */ elseif (preg_match('/<svg.*<\/svg>/is', $data)) {
			$type = 'svg';
		}
		// BMP images
		elseif (substr($data, 0, 2) == "BM") {
			$type = 'bmp';
		}
		return $type;
	}

	//==============================================================
	// Moved outside WMF as also needed for SVG
	function _putformobjects()
	{
		reset($this->formobjects);
		while (list($file, $info) = each($this->formobjects)) {
			$this->_newobj();
			$this->formobjects[$file]['n'] = $this->n;
			$this->_out('<</Type /XObject');
			$this->_out('/Subtype /Form');
			$this->_out('/Group ' . ($this->n + 1) . ' 0 R');
			$this->_out('/BBox [' . $info['x'] . ' ' . $info['y'] . ' ' . ($info['w'] + $info['x']) . ' ' . ($info['h'] + $info['y']) . ']');
			if ($this->compress)
				$this->_out('/Filter /FlateDecode');
			$data = ($this->compress) ? gzcompress($info['data']) : $info['data'];
			$this->_out('/Length ' . strlen($data) . '>>');
			$this->_putstream($data);
			unset($this->formobjects[$file]['data']);
			$this->_out('endobj');
			// Required for SVG transparency (opacity) to work
			$this->_newobj();
			$this->_out('<</Type /Group');
			$this->_out('/S /Transparency');
			$this->_out('>>');
			$this->_out('endobj');
		}
	}

	function _freadint($f)
	{
		//Read a 4-byte integer from file
		$i = ord(fread($f, 1)) << 24;
		$i+=ord(fread($f, 1)) << 16;
		$i+=ord(fread($f, 1)) << 8;
		$i+=ord(fread($f, 1));
		return $i;
	}

	function _UTF16BEtextstring($s)
	{
		$s = $this->UTF8ToUTF16BE($s, true);
		/* -- ENCRYPTION -- */
		if ($this->encrypted) {
			$s = $this->_RC4($this->_objectkey($this->_current_obj_id), $s);
		}
		/* -- END ENCRYPTION -- */
		return '(' . $this->_escape($s) . ')';
	}

	function _textstring($s)
	{
		/* -- ENCRYPTION -- */
		if ($this->encrypted) {
			$s = $this->_RC4($this->_objectkey($this->_current_obj_id), $s);
		}
		/* -- END ENCRYPTION -- */
		return '(' . $this->_escape($s) . ')';
	}

	function _escape($s)
	{
		// the chr(13) substitution fixes the Bugs item #1421290.
		return strtr($s, array(')' => '\\)', '(' => '\\(', '\\' => '\\\\', chr(13) => '\r'));
	}

	function _putstream($s)
	{
		/* -- ENCRYPTION -- */
		if ($this->encrypted) {
			$s = $this->_RC4($this->_objectkey($this->_current_obj_id), $s);
		}
		/* -- END ENCRYPTION -- */
		$this->_out('stream');
		$this->_out($s);
		$this->_out('endstream');
	}

	function _out($s, $ln = true)
	{
		if ($this->state == 2) {
			if ($this->bufferoutput) {
				$this->headerbuffer.= $s . "\n";
			}
			/* -- COLUMNS -- */ elseif (($this->ColActive) && !$this->processingHeader && !$this->processingFooter) {
				// Captures everything in buffer for columns; Almost everything is sent from fn. Cell() except:
				// Images sent from Image() or
				// later sent as _out($textto) in printbuffer
				// Line()
				if (preg_match('/q \d+\.\d\d+ 0 0 (\d+\.\d\d+) \d+\.\d\d+ \d+\.\d\d+ cm \/(I|FO)\d+ Do Q/', $s, $m)) { // Image data
					$h = ($m[1] / _MPDFK);
					// Update/overwrite the lowest bottom of printing y value for a column
					$this->ColDetails[$this->CurrCol]['bottom_margin'] = $this->y + $h;
				}
				/* -- TABLES -- */ elseif (preg_match('/\d+\.\d\d+ \d+\.\d\d+ \d+\.\d\d+ ([\-]{0,1}\d+\.\d\d+) re/', $s, $m) && $this->tableLevel > 0) { // Rect in table
					$h = ($m[1] / _MPDFK);
					// Update/overwrite the lowest bottom of printing y value for a column
					$this->ColDetails[$this->CurrCol]['bottom_margin'] = max($this->ColDetails[$this->CurrCol]['bottom_margin'], ($this->y + $h));
				}
				/* -- END TABLES -- */ else {  // Td Text Set in Cell()
					if (isset($this->ColDetails[$this->CurrCol]['bottom_margin'])) {
						$h = $this->ColDetails[$this->CurrCol]['bottom_margin'] - $this->y;
					} else {
						$h = 0;
					}
				}
				if ($h < 0) {
					$h = -$h;
				}
				$this->columnbuffer[] = array(
					's' => $s, // Text string to output
					'col' => $this->CurrCol, // Column when printed
					'x' => $this->x, // x when printed
					'y' => $this->y, // this->y when printed (after column break)
					'h' => $h        // actual y at bottom when printed = y+h
				);
			}
			/* -- END COLUMNS -- */
			/* -- TABLES -- */ elseif ($this->table_rotate && !$this->processingHeader && !$this->processingFooter) {
				// Captures eveything in buffer for rotated tables;
				$this->tablebuffer .= $s . "\n";
			}
			/* -- END TABLES -- */ elseif ($this->kwt && !$this->processingHeader && !$this->processingFooter) {
				// Captures eveything in buffer for keep-with-table (h1-6);
				$this->kwt_buffer[] = array(
					's' => $s, // Text string to output
					'x' => $this->x, // x when printed
					'y' => $this->y, // y when printed
				);
			} elseif (($this->keep_block_together) && !$this->processingHeader && !$this->processingFooter) {
				// do nothing
			} else {
				$this->pages[$this->page] .= $s . ($ln == true ? "\n" : '');
			}
		} else {
			$this->buffer .= $s . ($ln == true ? "\n" : '');
		}
	}

	/* -- WATERMARK -- */

	// add a watermark
	function watermark($texte, $angle = 45, $fontsize = 96, $alpha = 0.2)
	{
		if ($this->PDFA || $this->PDFX) {
			throw new MpdfException('PDFA and PDFX do not permit transparency, so mPDF does not allow Watermarks!');
		}
		if (!$this->watermark_font) {
			$this->watermark_font = $this->default_font;
		}
		$this->SetFont($this->watermark_font, "B", $fontsize, false); // Don't output
		$texte = $this->purify_utf8_text($texte);
		if ($this->text_input_as_HTML) {
			$texte = $this->all_entities_to_utf8($texte);
		}
		if ($this->usingCoreFont) {
			$texte = mb_convert_encoding($texte, $this->mb_enc, 'UTF-8');
		}

		// DIRECTIONALITY
		if (preg_match("/([" . $this->pregRTLchars . "])/u", $texte)) {
			$this->biDirectional = true;
		} // *OTL*

		$textvar = 0;
		$save_OTLtags = $this->OTLtags;
		$this->OTLtags = array();
		if ($this->useKerning) {
			if ($this->CurrentFont['haskernGPOS']) {
				$this->OTLtags['Plus'] .= ' kern';
			} else {
				$textvar = ($textvar | FC_KERNING);
			}
		}

		/* -- OTL -- */
		// Use OTL OpenType Table Layout - GSUB & GPOS
		if (isset($this->CurrentFont['useOTL']) && $this->CurrentFont['useOTL']) {
			$texte = $this->otl->applyOTL($texte, $this->CurrentFont['useOTL']);
			$OTLdata = $this->otl->OTLdata;
		}
		/* -- END OTL -- */
		$this->OTLtags = $save_OTLtags;

		$this->magic_reverse_dir($texte, $this->directionality, $OTLdata);

		$this->SetAlpha($alpha);

		$this->SetTColor($this->ConvertColor(0));
		$szfont = $fontsize;
		$loop = 0;
		$maxlen = (min($this->w, $this->h) ); // sets max length of text as 7/8 width/height of page
		while ($loop == 0) {
			$this->SetFont($this->watermark_font, "B", $szfont, false); // Don't output
			$offset = ((sin(deg2rad($angle))) * ($szfont / _MPDFK));

			$strlen = $this->GetStringWidth($texte, true, $OTLdata, $textvar);
			if ($strlen > $maxlen - $offset)
				$szfont --;
			else
				$loop ++;
		}

		$this->SetFont($this->watermark_font, "B", $szfont - 0.1, true, true); // Output The -0.1 is because SetFont above is not written to PDF
		// Repeating it will not output anything as mPDF thinks it is set
		$adj = ((cos(deg2rad($angle))) * ($strlen / 2));
		$opp = ((sin(deg2rad($angle))) * ($strlen / 2));
		$wx = ($this->w / 2) - $adj + $offset / 3;
		$wy = ($this->h / 2) + $opp;
		$this->Rotate($angle, $wx, $wy);
		$this->Text($wx, $wy, $texte, $OTLdata, $textvar);
		$this->Rotate(0);
		$this->SetTColor($this->ConvertColor(0));

		$this->SetAlpha(1);
	}

	function watermarkImg($src, $alpha = 0.2)
	{
		if ($this->PDFA || $this->PDFX) {
			throw new MpdfException('PDFA and PDFX do not permit transparency, so mPDF does not allow Watermarks!');
		}
		if ($this->watermarkImgBehind) {
			$this->watermarkImgAlpha = $this->SetAlpha($alpha, 'Normal', true);
		} else {
			$this->SetAlpha($alpha, $this->watermarkImgAlphaBlend);
		}
		$this->Image($src, 0, 0, 0, 0, '', '', true, true, true);
		if (!$this->watermarkImgBehind) {
			$this->SetAlpha(1);
		}
	}

	/* -- END WATERMARK -- */

	function Rotate($angle, $x = -1, $y = -1)
	{
		if ($x == -1)
			$x = $this->x;
		if ($y == -1)
			$y = $this->y;
		if ($this->angle != 0)
			$this->_out('Q');
		$this->angle = $angle;
		if ($angle != 0) {
			$angle*=M_PI / 180;
			$c = cos($angle);
			$s = sin($angle);
			$cx = $x * _MPDFK;
			$cy = ($this->h - $y) * _MPDFK;
			$this->_out(sprintf('q %.5F %.5F %.5F %.5F %.3F %.3F cm 1 0 0 1 %.3F %.3F cm', $c, $s, -$s, $c, $cx, $cy, -$cx, -$cy));
		}
	}

	function CircularText($x, $y, $r, $text, $align = 'top', $fontfamily = '', $fontsize = 0, $fontstyle = '', $kerning = 120, $fontwidth = 100, $divider)
	{
		if (!class_exists('directw', false)) {
			include(_MPDF_PATH . 'classes/directw.php');
		}
		if (empty($this->directw)) {
			$this->directw = new directw($this);
		}
		$this->directw->CircularText($x, $y, $r, $text, $align, $fontfamily, $fontsize, $fontstyle, $kerning, $fontwidth, $divider);
	}

	// From Invoice
	function RoundedRect($x, $y, $w, $h, $r, $style = '')
	{
		$hp = $this->h;
		if ($style == 'F')
			$op = 'f';
		elseif ($style == 'FD' or $style == 'DF')
			$op = 'B';
		else
			$op = 'S';
		$MyArc = 4 / 3 * (sqrt(2) - 1);
		$this->_out(sprintf('%.3F %.3F m', ($x + $r) * _MPDFK, ($hp - $y) * _MPDFK));
		$xc = $x + $w - $r;
		$yc = $y + $r;
		$this->_out(sprintf('%.3F %.3F l', $xc * _MPDFK, ($hp - $y) * _MPDFK));

		$this->_Arc($xc + $r * $MyArc, $yc - $r, $xc + $r, $yc - $r * $MyArc, $xc + $r, $yc);
		$xc = $x + $w - $r;
		$yc = $y + $h - $r;
		$this->_out(sprintf('%.3F %.3F l', ($x + $w) * _MPDFK, ($hp - $yc) * _MPDFK));
		$this->_Arc($xc + $r, $yc + $r * $MyArc, $xc + $r * $MyArc, $yc + $r, $xc, $yc + $r);
		$xc = $x + $r;
		$yc = $y + $h - $r;
		$this->_out(sprintf('%.3F %.3F l', $xc * _MPDFK, ($hp - ($y + $h)) * _MPDFK));
		$this->_Arc($xc - $r * $MyArc, $yc + $r, $xc - $r, $yc + $r * $MyArc, $xc - $r, $yc);
		$xc = $x + $r;
		$yc = $y + $r;
		$this->_out(sprintf('%.3F %.3F l', ($x) * _MPDFK, ($hp - $yc) * _MPDFK));
		$this->_Arc($xc - $r, $yc - $r * $MyArc, $xc - $r * $MyArc, $yc - $r, $xc, $yc - $r);
		$this->_out($op);
	}

	function _Arc($x1, $y1, $x2, $y2, $x3, $y3)
	{
		$h = $this->h;
		$this->_out(sprintf('%.3F %.3F %.3F %.3F %.3F %.3F c ', $x1 * _MPDFK, ($h - $y1) * _MPDFK, $x2 * _MPDFK, ($h - $y2) * _MPDFK, $x3 * _MPDFK, ($h - $y3) * _MPDFK));
	}

	//====================================================



	/* -- DIRECTW -- */
	function Shaded_box($text, $font = '', $fontstyle = 'B', $szfont = '', $width = '70%', $style = 'DF', $radius = 2.5, $fill = '#FFFFFF', $color = '#000000', $pad = 2)
	{
		// F (shading - no line),S (line, no shading),DF (both)
		if (!class_exists('directw', false)) {
			include(_MPDF_PATH . 'classes/directw.php');
		}
		if (empty($this->directw)) {
			$this->directw = new directw($this);
		}
		$this->directw->Shaded_box($text, $font, $fontstyle, $szfont, $width, $style, $radius, $fill, $color, $pad);
	}

	/* -- END DIRECTW -- */

	function UTF8StringToArray($str, $addSubset = true)
	{
		$out = array();
		$len = strlen($str);
		for ($i = 0; $i < $len; $i++) {
			$uni = -1;
			$h = ord($str[$i]);
			if ($h <= 0x7F)
				$uni = $h;
			elseif ($h >= 0xC2) {
				if (($h <= 0xDF) && ($i < $len - 1))
					$uni = ($h & 0x1F) << 6 | (ord($str[++$i]) & 0x3F);
				elseif (($h <= 0xEF) && ($i < $len - 2))
					$uni = ($h & 0x0F) << 12 | (ord($str[++$i]) & 0x3F) << 6 | (ord($str[++$i]) & 0x3F);
				elseif (($h <= 0xF4) && ($i < $len - 3))
					$uni = ($h & 0x0F) << 18 | (ord($str[++$i]) & 0x3F) << 12 | (ord($str[++$i]) & 0x3F) << 6 | (ord($str[++$i]) & 0x3F);
			}
			if ($uni >= 0) {
				$out[] = $uni;
				if ($addSubset && isset($this->CurrentFont['subset'])) {
					$this->CurrentFont['subset'][$uni] = $uni;
				}
			}
		}
		return $out;
	}

	//Convert utf-8 string to <HHHHHH> for Font Subsets
	function UTF8toSubset($str)
	{
		$ret = '<';
		//$str = preg_replace('/'.preg_quote($this->aliasNbPg,'/').'/', chr(7), $str );	// mPDF 6 deleted
		//$str = preg_replace('/'.preg_quote($this->aliasNbPgGp,'/').'/', chr(8), $str );	// mPDF 6 deleted
		$unicode = $this->UTF8StringToArray($str);
		$orig_fid = $this->CurrentFont['subsetfontids'][0];
		$last_fid = $this->CurrentFont['subsetfontids'][0];
		foreach ($unicode as $c) {
			/* 	// mPDF 6 deleted
			  if ($c == 7 || $c == 8) {
			  if ($orig_fid != $last_fid) {
			  $ret .= '> Tj /F'.$orig_fid.' '.$this->FontSizePt.' Tf <';
			  $last_fid = $orig_fid;
			  }
			  if ($c == 7) { $ret .= $this->aliasNbPgHex; }
			  else { $ret .= $this->aliasNbPgGpHex; }
			  continue;
			  }
			 */
			if (!$this->_charDefined($this->CurrentFont['cw'], $c)) {
				$c = 0;
			} // mPDF 6
			for ($i = 0; $i < 99; $i++) {
				// return c as decimal char
				$init = array_search($c, $this->CurrentFont['subsets'][$i]);
				if ($init !== false) {
					if ($this->CurrentFont['subsetfontids'][$i] != $last_fid) {
						$ret .= '> Tj /F' . $this->CurrentFont['subsetfontids'][$i] . ' ' . $this->FontSizePt . ' Tf <';
						$last_fid = $this->CurrentFont['subsetfontids'][$i];
					}
					$ret .= sprintf("%02s", strtoupper(dechex($init)));
					break;
				}
				// TrueType embedded SUBSETS
				elseif (count($this->CurrentFont['subsets'][$i]) < 255) {
					$n = count($this->CurrentFont['subsets'][$i]);
					$this->CurrentFont['subsets'][$i][$n] = $c;
					if ($this->CurrentFont['subsetfontids'][$i] != $last_fid) {
						$ret .= '> Tj /F' . $this->CurrentFont['subsetfontids'][$i] . ' ' . $this->FontSizePt . ' Tf <';
						$last_fid = $this->CurrentFont['subsetfontids'][$i];
					}
					$ret .= sprintf("%02s", strtoupper(dechex($n)));
					break;
				} elseif (!isset($this->CurrentFont['subsets'][($i + 1)])) {
					// TrueType embedded SUBSETS
					$this->CurrentFont['subsets'][($i + 1)] = array(0 => 0);
					$new_fid = count($this->fonts) + $this->extraFontSubsets + 1;
					$this->CurrentFont['subsetfontids'][($i + 1)] = $new_fid;
					$this->extraFontSubsets++;
				}
			}
		}
		$ret .= '>';
		if ($last_fid != $orig_fid) {
			$ret .= ' Tj /F' . $orig_fid . ' ' . $this->FontSizePt . ' Tf <> ';
		}
		return $ret;
	}

	// Converts UTF-8 strings to UTF16-BE.
	function UTF8ToUTF16BE($str, $setbom = true)
	{
		if ($this->checkSIP && preg_match("/([\x{20000}-\x{2FFFF}])/u", $str)) {
			if (!in_array($this->currentfontfamily, array('gb', 'big5', 'sjis', 'uhc', 'gbB', 'big5B', 'sjisB', 'uhcB', 'gbI', 'big5I', 'sjisI', 'uhcI',
					'gbBI', 'big5BI', 'sjisBI', 'uhcBI'))) {
				$str = preg_replace("/[\x{20000}-\x{2FFFF}]/u", chr(0), $str);
			}
		}
		if ($this->checkSMP && preg_match("/([\x{10000}-\x{1FFFF}])/u", $str)) {
			$str = preg_replace("/[\x{10000}-\x{1FFFF}]/u", chr(0), $str);
		}
		$outstr = ""; // string to be returned
		if ($setbom) {
			$outstr .= "\xFE\xFF"; // Byte Order Mark (BOM)
		}
		$outstr .= mb_convert_encoding($str, 'UTF-16BE', 'UTF-8');
		return $outstr;
	}

	// ====================================================
	// ====================================================
		/* -- CJK-FONTS -- */

	// from class PDF_Chinese CJK EXTENSIONS
	function AddCIDFont($family, $style, $name, &$cw, $CMap, $registry, $desc)
	{
		$fontkey = strtolower($family) . strtoupper($style);
		if (isset($this->fonts[$fontkey]))
			throw new MpdfException("Font already added: $family $style");
		$i = count($this->fonts) + $this->extraFontSubsets + 1;
		$name = str_replace(' ', '', $name);
		if ($family == 'sjis') {
			$up = -120;
		} else {
			$up = -130;
		}
		// ? 'up' and 'ut' do not seem to be referenced anywhere
		$this->fonts[$fontkey] = array('i' => $i, 'type' => 'Type0', 'name' => $name, 'up' => $up, 'ut' => 40, 'cw' => $cw, 'CMap' => $CMap, 'registry' => $registry, 'MissingWidth' => 1000, 'desc' => $desc);
	}

	function AddCJKFont($family)
	{

		if ($this->PDFA || $this->PDFX) {
			throw new MpdfException("Adobe CJK fonts cannot be embedded in mPDF (required for PDFA1-b and PDFX/1-a).");
		}
		if ($family == 'big5') {
			$this->AddBig5Font();
		} elseif ($family == 'gb') {
			$this->AddGBFont();
		} elseif ($family == 'sjis') {
			$this->AddSJISFont();
		} elseif ($family == 'uhc') {
			$this->AddUHCFont();
		}
	}

	function AddBig5Font()
	{
		//Add Big5 font with proportional Latin
		$family = 'big5';
		$name = 'MSungStd-Light-Acro';
		$cw = $this->Big5_widths;
		$CMap = 'UniCNS-UTF16-H';
		$registry = array('ordering' => 'CNS1', 'supplement' => 4);
		$desc = array(
			'Ascent' => 880,
			'Descent' => -120,
			'CapHeight' => 880,
			'Flags' => 6,
			'FontBBox' => '[-160 -249 1015 1071]',
			'ItalicAngle' => 0,
			'StemV' => 93,
		);
		$this->AddCIDFont($family, '', $name, $cw, $CMap, $registry, $desc);
		$this->AddCIDFont($family, 'B', $name . ',Bold', $cw, $CMap, $registry, $desc);
		$this->AddCIDFont($family, 'I', $name . ',Italic', $cw, $CMap, $registry, $desc);
		$this->AddCIDFont($family, 'BI', $name . ',BoldItalic', $cw, $CMap, $registry, $desc);
	}

	function AddGBFont()
	{
		//Add GB font with proportional Latin
		$family = 'gb';
		$name = 'STSongStd-Light-Acro';
		$cw = $this->GB_widths;
		$CMap = 'UniGB-UTF16-H';
		$registry = array('ordering' => 'GB1', 'supplement' => 4);
		$desc = array(
			'Ascent' => 880,
			'Descent' => -120,
			'CapHeight' => 737,
			'Flags' => 6,
			'FontBBox' => '[-25 -254 1000 880]',
			'ItalicAngle' => 0,
			'StemV' => 58,
			'Style' => '<< /Panose <000000000400000000000000> >>',
		);
		$this->AddCIDFont($family, '', $name, $cw, $CMap, $registry, $desc);
		$this->AddCIDFont($family, 'B', $name . ',Bold', $cw, $CMap, $registry, $desc);
		$this->AddCIDFont($family, 'I', $name . ',Italic', $cw, $CMap, $registry, $desc);
		$this->AddCIDFont($family, 'BI', $name . ',BoldItalic', $cw, $CMap, $registry, $desc);
	}

	function AddSJISFont()
	{
		//Add SJIS font with proportional Latin
		$family = 'sjis';
		$name = 'KozMinPro-Regular-Acro';
		$cw = $this->SJIS_widths;
		$CMap = 'UniJIS-UTF16-H';
		$registry = array('ordering' => 'Japan1', 'supplement' => 5);
		$desc = array(
			'Ascent' => 880,
			'Descent' => -120,
			'CapHeight' => 740,
			'Flags' => 6,
			'FontBBox' => '[-195 -272 1110 1075]',
			'ItalicAngle' => 0,
			'StemV' => 86,
			'XHeight' => 502,
		);
		$this->AddCIDFont($family, '', $name, $cw, $CMap, $registry, $desc);
		$this->AddCIDFont($family, 'B', $name . ',Bold', $cw, $CMap, $registry, $desc);
		$this->AddCIDFont($family, 'I', $name . ',Italic', $cw, $CMap, $registry, $desc);
		$this->AddCIDFont($family, 'BI', $name . ',BoldItalic', $cw, $CMap, $registry, $desc);
	}

	function AddUHCFont()
	{
		//Add UHC font with proportional Latin
		$family = 'uhc';
		$name = 'HYSMyeongJoStd-Medium-Acro';
		$cw = $this->UHC_widths;
		$CMap = 'UniKS-UTF16-H';
		$registry = array('ordering' => 'Korea1', 'supplement' => 2);
		$desc = array(
			'Ascent' => 880,
			'Descent' => -120,
			'CapHeight' => 720,
			'Flags' => 6,
			'FontBBox' => '[-28 -148 1001 880]',
			'ItalicAngle' => 0,
			'StemV' => 60,
			'Style' => '<< /Panose <000000000600000000000000> >>',
		);
		$this->AddCIDFont($family, '', $name, $cw, $CMap, $registry, $desc);
		$this->AddCIDFont($family, 'B', $name . ',Bold', $cw, $CMap, $registry, $desc);
		$this->AddCIDFont($family, 'I', $name . ',Italic', $cw, $CMap, $registry, $desc);
		$this->AddCIDFont($family, 'BI', $name . ',BoldItalic', $cw, $CMap, $registry, $desc);
	}

	/* -- END CJK-FONTS -- */

	//////////////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////

	function SetDefaultFont($font)
	{
		// Disallow embedded fonts to be used as defaults in PDFA
		if ($this->PDFA || $this->PDFX) {
			if (strtolower($font) == 'ctimes') {
				$font = 'serif';
			}
			if (strtolower($font) == 'ccourier') {
				$font = 'monospace';
			}
			if (strtolower($font) == 'chelvetica') {
				$font = 'sans-serif';
			}
		}
		$font = $this->SetFont($font); // returns substituted font if necessary
		$this->default_font = $font;
		$this->original_default_font = $font;
		if (!$this->watermark_font) {
			$this->watermark_font = $font;
		} // *WATERMARK*
		$this->defaultCSS['BODY']['FONT-FAMILY'] = $font;
		$this->cssmgr->CSS['BODY']['FONT-FAMILY'] = $font;
	}

	function SetDefaultFontSize($fontsize)
	{
		$this->default_font_size = $fontsize;
		$this->original_default_font_size = $fontsize;
		$this->SetFontSize($fontsize);
		$this->defaultCSS['BODY']['FONT-SIZE'] = $fontsize . 'pt';
		$this->cssmgr->CSS['BODY']['FONT-SIZE'] = $fontsize . 'pt';
	}

	function SetDefaultBodyCSS($prop, $val)
	{
		if ($prop) {
			$this->defaultCSS['BODY'][strtoupper($prop)] = $val;
			$this->cssmgr->CSS['BODY'][strtoupper($prop)] = $val;
		}
	}

	function SetDirectionality($dir = 'ltr')
	{
		/* -- OTL -- */
		if (strtolower($dir) == 'rtl') {
			if ($this->directionality != 'rtl') {
				// Swop L/R Margins so page 1 RTL is an 'even' page
				$tmp = $this->DeflMargin;
				$this->DeflMargin = $this->DefrMargin;
				$this->DefrMargin = $tmp;
				$this->orig_lMargin = $this->DeflMargin;
				$this->orig_rMargin = $this->DefrMargin;

				$this->SetMargins($this->DeflMargin, $this->DefrMargin, $this->tMargin);
			}
			$this->directionality = 'rtl';
			$this->defaultAlign = 'R';
			$this->defaultTableAlign = 'R';
		} else {
			/* -- END OTL -- */
			$this->directionality = 'ltr';
			$this->defaultAlign = 'L';
			$this->defaultTableAlign = 'L';
		} // *OTL*
		$this->cssmgr->CSS['BODY']['DIRECTION'] = $this->directionality;
	}

	// Return either a number (factor) - based on current set fontsize (if % or em) - or exact lineheight (with 'mm' after it)
	function fixLineheight($v)
	{
		$lh = false;
		if (preg_match('/^[0-9\.,]*$/', $v) && $v >= 0) {
			return ($v + 0);
		} elseif (strtoupper($v) == 'NORMAL' || $v == 'N') {
			return 'N';  // mPDF 6
		} else {
			$tlh = $this->ConvertSize($v, $this->FontSize, $this->FontSize, true);
			if ($tlh) {
				return ($tlh . 'mm');
			}
		}
		return $this->normalLineheight;
	}

	function _getNormalLineheight($desc = false)
	{
		if (!$desc) {
			$desc = $this->CurrentFont['desc'];
		}
		if (!isset($desc['Leading'])) {
			$desc['Leading'] = 0;
		}
		if ($this->useFixedNormalLineHeight) {
			$lh = $this->normalLineheight;
		} elseif (isset($desc['Ascent']) && $desc['Ascent']) {
			$lh = ($this->adjustFontDescLineheight * ($desc['Ascent'] - $desc['Descent'] + $desc['Leading']) / 1000);
		} else {
			$lh = $this->normalLineheight;
		}
		return $lh;
	}

	// Set a (fixed) lineheight to an actual value - either to named fontsize(pts) or default
	function SetLineHeight($FontPt = '', $lh = '')
	{
		if (!$FontPt) {
			$FontPt = $this->FontSizePt;
		}
		$fs = $FontPt / _MPDFK;
		$this->lineheight = $this->_computeLineheight($lh, $fs);
	}

	function _computeLineheight($lh, $fs = '')
	{
		if ($this->shrin_k > 1) {
			$k = $this->shrin_k;
		} else {
			$k = 1;
		}
		if (!$fs) {
			$fs = $this->FontSize;
		}
		if ($lh == 'N') {
			$lh = $this->_getNormalLineheight();
		}
		if (preg_match('/mm/', $lh)) {
			return (($lh + 0.0) / $k); // convert to number
		} elseif ($lh > 0) {
			return ($fs * $lh);
		}
		return ($fs * $this->normalLineheight);
	}

	function _setLineYpos(&$fontsize, &$fontdesc, &$CSSlineheight, $blockYpos = false)
	{
		$ypos['glyphYorigin'] = 0;
		$ypos['baseline-shift'] = 0;
		$linegap = 0;
		$leading = 0;

		if (isset($fontdesc['Ascent']) && $fontdesc['Ascent'] && !$this->useFixedTextBaseline) {
			// Fontsize uses font metrics - this method seems to produce results compatible with browsers (except IE9)
			$ypos['boxtop'] = $fontdesc['Ascent'] / 1000 * $fontsize;
			$ypos['boxbottom'] = $fontdesc['Descent'] / 1000 * $fontsize;
			if (isset($fontdesc['Leading'])) {
				$linegap = $fontdesc['Leading'] / 1000 * $fontsize;
			}
		}
		// Default if not set - uses baselineC
		else {
			$ypos['boxtop'] = (0.5 + $this->baselineC) * $fontsize;
			$ypos['boxbottom'] = -(0.5 - $this->baselineC) * $fontsize;
		}
		$fontheight = $ypos['boxtop'] - $ypos['boxbottom'];

		if ($this->shrin_k > 1) {
			$shrin_k = $this->shrin_k;
		} else {
			$shrin_k = 1;
		}

		$leading = 0;
		if ($CSSlineheight == 'N') {
			$lh = $this->_getNormalLineheight($fontdesc);
			$lineheight = ($fontsize * $lh);
			$leading += $linegap; // specified in hhea or sTypo in OpenType tables	****************************************
		} elseif (preg_match('/mm/', $CSSlineheight)) {
			$lineheight = (($CSSlineheight + 0.0) / $shrin_k);
		} // convert to number
		// ??? If lineheight is a factor e.g. 1.3  ?? use factor x 1em or ? use 'normal' lineheight * factor ******************************
		// Could depend on value for $text_height - a draft CSS value as set above for now
		elseif ($CSSlineheight > 0) {
			$lineheight = ($fontsize * $CSSlineheight);
		} else {
			$lineheight = ($fontsize * $this->normalLineheight);
		}

		// In general, calculate the "leading" - the difference between the fontheight and the lineheight
		// and add half to the top and half to the bottom. BUT
		// If an inline element has a font-size less than the block element, and the line-height is set as an em or % value
		// it will add too much leading below the font and expand the height of the line - so just use the block element exttop/extbottom:
		if (preg_match('/mm/', $CSSlineheight) && $ypos['boxtop'] < $blockYpos['boxtop'] && $ypos['boxbottom'] > $blockYpos['boxbottom']) {
			$ypos['exttop'] = $blockYpos['exttop'];
			$ypos['extbottom'] = $blockYpos['extbottom'];
		} else {
			$leading += ($lineheight - $fontheight);

			$ypos['exttop'] = $ypos['boxtop'] + $leading / 2;
			$ypos['extbottom'] = $ypos['boxbottom'] - $leading / 2;
		}


		// TEMP ONLY FOR DEBUGGING *********************************
		//$ypos['lineheight'] = $lineheight;
		//$ypos['fontheight'] = $fontheight;
		//$ypos['leading'] = $leading;

		return $ypos;
	}

	/* Called from WriteFlowingBlock() and finishFlowingBlock()
	  Determines the line hieght and glyph/writing position
	  for each element in the line to be written */

	function _setInlineBlockHeights(&$lineBox, &$stackHeight, &$content, &$font, $is_table)
	{
		if ($this->shrin_k > 1) {
			$shrin_k = $this->shrin_k;
		} else {
			$shrin_k = 1;
		}

		$ypos = array();
		$bordypos = array();
		$bgypos = array();

		if ($is_table) {
			// FOR TABLE
			$fontsize = $this->FontSize;
			$fontkey = $this->FontFamily . $this->FontStyle;
			$fontdesc = $this->fonts[$fontkey]['desc'];
			$CSSlineheight = $this->cellLineHeight;
			$line_stacking_strategy = $this->cellLineStackingStrategy; // inline-line-height [default] | block-line-height | max-height | grid-height
			$line_stacking_shift = $this->cellLineStackingShift;  // consider-shifts [default] | disregard-shifts
		} else {
			// FOR BLOCK FONT
			$fontsize = $this->blk[$this->blklvl]['InlineProperties']['size'];
			$fontkey = $this->blk[$this->blklvl]['InlineProperties']['family'] . $this->blk[$this->blklvl]['InlineProperties']['style'];
			$fontdesc = $this->fonts[$fontkey]['desc'];
			$CSSlineheight = $this->blk[$this->blklvl]['line_height'];
			// inline-line-height | block-line-height | max-height | grid-height
			$line_stacking_strategy = (isset($this->blk[$this->blklvl]['line_stacking_strategy']) ? $this->blk[$this->blklvl]['line_stacking_strategy'] : 'inline-line-height');
			// consider-shifts | disregard-shifts
			$line_stacking_shift = (isset($this->blk[$this->blklvl]['line_stacking_shift']) ? $this->blk[$this->blklvl]['line_stacking_shift'] : 'consider-shifts');
		}
		$boxLineHeight = $this->_computeLineheight($CSSlineheight, $fontsize);


		// First, set a "strut" using block font at index $lineBox[-1]
		$ypos[-1] = $this->_setLineYpos($fontsize, $fontdesc, $CSSlineheight);

		// for the block element - always taking the block EXTENDED progression including leading - which may be negative
		if ($line_stacking_strategy == 'block-line-height') {
			$topy = $ypos[-1]['exttop'];
			$bottomy = $ypos[-1]['extbottom'];
		} else {
			$topy = 0;
			$bottomy = 0;
		}

		// Get text-middle for aligning images/objects
		$midpoint = $ypos[-1]['boxtop'] - (($ypos[-1]['boxtop'] - $ypos[-1]['boxbottom']) / 2);

		// for images / inline objects / replaced elements
		$mta = 0; // Maximum top-aligned
		$mba = 0; // Maximum bottom-aligned
		foreach ($content as $k => $chunk) {
			if (isset($this->objectbuffer[$k]) && $this->objectbuffer[$k]['type'] == 'listmarker') {
				$ypos[$k] = $ypos[-1];
				// UPDATE Maximums
				if ($line_stacking_strategy == 'block-line-height' || $line_stacking_strategy == 'grid-height' || $line_stacking_strategy == 'max-height') { // don't include extended block progression of all inline elements
					if ($ypos[$k]['boxtop'] > $topy)
						$topy = $ypos[$k]['boxtop'];
					if ($ypos[$k]['boxbottom'] < $bottomy)
						$bottomy = $ypos[$k]['boxbottom'];
				}
				else {
					if ($ypos[$k]['exttop'] > $topy)
						$topy = $ypos[$k]['exttop'];
					if ($ypos[$k]['extbottom'] < $bottomy)
						$bottomy = $ypos[$k]['extbottom'];
				}
			}
			elseif (isset($this->objectbuffer[$k]) && $this->objectbuffer[$k]['type'] == 'dottab') { // mPDF 6 DOTTAB
				$fontsize = $font[$k]['size'];
				$fontdesc = $font[$k]['curr']['desc'];
				$lh = 1;
				$ypos[$k] = $this->_setLineYpos($fontsize, $fontdesc, $lh, $ypos[-1]); // Lineheight=1 fixed
			} elseif (isset($this->objectbuffer[$k])) {
				$oh = $this->objectbuffer[$k]['OUTER-HEIGHT'];
				$va = $this->objectbuffer[$k]['vertical-align'];

				if ($va == 'BS') { //  (BASELINE default)
					if ($oh > $topy)
						$topy = $oh;
				}
				elseif ($va == 'M') {
					if (($midpoint + $oh / 2) > $topy)
						$topy = $midpoint + $oh / 2;
					if (($midpoint - $oh / 2) < $bottomy)
						$bottomy = $midpoint - $oh / 2;
				}
				elseif ($va == 'TT') {
					if (($ypos[-1]['boxtop'] - $oh) < $bottomy) {
						$bottomy = $ypos[-1]['boxtop'] - $oh;
						$topy = max($topy, $ypos[-1]['boxtop']);
					}
				} elseif ($va == 'TB') {
					if (($ypos[-1]['boxbottom'] + $oh) > $topy) {
						$topy = $ypos[-1]['boxbottom'] + $oh;
						$bottomy = min($bottomy, $ypos[-1]['boxbottom']);
					}
				} elseif ($va == 'T') {
					if ($oh > $mta)
						$mta = $oh;
				}
				elseif ($va == 'B') {
					if ($oh > $mba)
						$mba = $oh;
				}
			}
			elseif ($content[$k] || $content[$k] === '0') {
				// FOR FLOWING BLOCK
				$fontsize = $font[$k]['size'];
				$fontdesc = $font[$k]['curr']['desc'];
				// In future could set CSS line-height from inline elements; for now, use block level:
				$ypos[$k] = $this->_setLineYpos($fontsize, $fontdesc, $CSSlineheight, $ypos[-1]);

				if (isset($font[$k]['textparam']['text-baseline']) && $font[$k]['textparam']['text-baseline'] != 0) {
					$ypos[$k]['baseline-shift'] = $font[$k]['textparam']['text-baseline'];
				}

				// DO ALIGNMENT FOR BASELINES *******************
				// Until most fonts have OpenType BASE tables, this won't work
				// $ypos[$k] compared to $ypos[-1] or $ypos[$k-1] using $dominant_baseline and $baseline_table
				// UPDATE Maximums
				if ($line_stacking_strategy == 'block-line-height' || $line_stacking_strategy == 'grid-height' || $line_stacking_strategy == 'max-height') { // don't include extended block progression of all inline elements
					if ($line_stacking_shift == 'disregard-shifts') {
						if ($ypos[$k]['boxtop'] > $topy)
							$topy = $ypos[$k]['boxtop'];
						if ($ypos[$k]['boxbottom'] < $bottomy)
							$bottomy = $ypos[$k]['boxbottom'];
					}
					else {
						if (($ypos[$k]['boxtop'] + $ypos[$k]['baseline-shift']) > $topy)
							$topy = $ypos[$k]['boxtop'] + $ypos[$k]['baseline-shift'];
						if (($ypos[$k]['boxbottom'] + $ypos[$k]['baseline-shift']) < $bottomy)
							$bottomy = $ypos[$k]['boxbottom'] + $ypos[$k]['baseline-shift'];
					}
				}
				else {
					if ($line_stacking_shift == 'disregard-shifts') {
						if ($ypos[$k]['exttop'] > $topy)
							$topy = $ypos[$k]['exttop'];
						if ($ypos[$k]['extbottom'] < $bottomy)
							$bottomy = $ypos[$k]['extbottom'];
					}
					else {
						if (($ypos[$k]['exttop'] + $ypos[$k]['baseline-shift']) > $topy)
							$topy = $ypos[$k]['exttop'] + $ypos[$k]['baseline-shift'];
						if (($ypos[$k]['extbottom'] + $ypos[$k]['baseline-shift']) < $bottomy)
							$bottomy = $ypos[$k]['extbottom'] + $ypos[$k]['baseline-shift'];
					}
				}

				// If BORDER set on inline element
				if (isset($font[$k]['bord']) && $font[$k]['bord']) {
					$bordfontsize = $font[$k]['textparam']['bord-decoration']['fontsize'] / $shrin_k;
					$bordfontkey = $font[$k]['textparam']['bord-decoration']['fontkey'];
					if ($bordfontkey != $fontkey || $bordfontsize != $fontsize || isset($font[$k]['textparam']['bord-decoration']['baseline'])) {
						$bordfontdesc = $this->fonts[$bordfontkey]['desc'];
						$bordypos[$k] = $this->_setLineYpos($bordfontsize, $bordfontdesc, $CSSlineheight, $ypos[-1]);
						if (isset($font[$k]['textparam']['bord-decoration']['baseline']) && $font[$k]['textparam']['bord-decoration']['baseline'] != 0) {
							$bordypos[$k]['baseline-shift'] = $font[$k]['textparam']['bord-decoration']['baseline'] / $shrin_k;
						}
					}
				}
				// If BACKGROUND set on inline element
				if (isset($font[$k]['spanbgcolor']) && $font[$k]['spanbgcolor']) {
					$bgfontsize = $font[$k]['textparam']['bg-decoration']['fontsize'] / $shrin_k;
					$bgfontkey = $font[$k]['textparam']['bg-decoration']['fontkey'];
					if ($bgfontkey != $fontkey || $bgfontsize != $fontsize || isset($font[$k]['textparam']['bg-decoration']['baseline'])) {
						$bgfontdesc = $this->fonts[$bgfontkey]['desc'];
						$bgypos[$k] = $this->_setLineYpos($bgfontsize, $bgfontdesc, $CSSlineheight, $ypos[-1]);
						if (isset($font[$k]['textparam']['bg-decoration']['baseline']) && $font[$k]['textparam']['bg-decoration']['baseline'] != 0) {
							$bgypos[$k]['baseline-shift'] = $font[$k]['textparam']['bg-decoration']['baseline'] / $shrin_k;
						}
					}
				}
			}
		}


		// TOP or BOTTOM aligned images
		if ($mta > ($topy - $bottomy)) {
			if (($topy - $mta) < $bottomy)
				$bottomy = $topy - $mta;
		}
		if ($mba > ($topy - $bottomy)) {
			if (($bottomy + $mba) > $topy)
				$topy = $bottomy + $mba;
		}

		if ($line_stacking_strategy == 'block-line-height') { // fixed height set by block element (whether present or not)
			$topy = $ypos[-1]['exttop'];
			$bottomy = $ypos[-1]['extbottom'];
		}

		$inclusiveHeight = $topy - $bottomy;

		// SET $stackHeight taking note of line_stacking_strategy
		// NB inclusive height already takes account of need to consider block progression height (excludes leading set by lineheight)
		// or extended block progression height (includes leading set by lineheight)
		if ($line_stacking_strategy == 'block-line-height') { // fixed = extended block progression height of block element
			$stackHeight = $boxLineHeight;
		} elseif ($line_stacking_strategy == 'max-height') { // smallest height which includes extended block progression height of block element
			// and block progression heights of inline elements (NOT extended)
			$stackHeight = $inclusiveHeight;
		} elseif ($line_stacking_strategy == 'grid-height') { // smallest multiple of block element lineheight to include
			// block progression heights of inline elements (NOT extended)
			$stackHeight = $boxLineHeight;
			while ($stackHeight < $inclusiveHeight) {
				$stackHeight += $boxLineHeight;
			}
		} else { // 'inline-line-height' = default		// smallest height which includes extended block progression height of block element
			// AND extended block progression heights of inline elements
			$stackHeight = $inclusiveHeight;
		}

		$diff = $stackHeight - $inclusiveHeight;
		$topy += $diff / 2;
		$bottomy -= $diff / 2;

		// ADJUST $ypos => lineBox using $stackHeight; lineBox are all offsets from the top of stackHeight in mm
		// and SET IMAGE OFFSETS
		$lineBox[-1]['boxtop'] = $topy - $ypos[-1]['boxtop'];
		$lineBox[-1]['boxbottom'] = $topy - $ypos[-1]['boxbottom'];
		//	$lineBox[-1]['exttop'] = $topy - $ypos[-1]['exttop'];
		//	$lineBox[-1]['extbottom'] = $topy - $ypos[-1]['extbottom'];
		$lineBox[-1]['glyphYorigin'] = $topy - $ypos[-1]['glyphYorigin'];
		$lineBox[-1]['baseline-shift'] = $ypos[-1]['baseline-shift'];

		$midpoint = $lineBox[-1]['boxbottom'] - (($lineBox[-1]['boxbottom'] - $lineBox[-1]['boxtop']) / 2);

		foreach ($content as $k => $chunk) {
			if (isset($this->objectbuffer[$k])) {
				$oh = $this->objectbuffer[$k]['OUTER-HEIGHT'];
				// LIST MARKERS
				if ($this->objectbuffer[$k]['type'] == 'listmarker') {
					$oh = $fontsize;
				} elseif ($this->objectbuffer[$k]['type'] == 'dottab') { // mPDF 6 DOTTAB
					$oh = $font[$k]['size']; // == $this->objectbuffer[$k]['fontsize']/_MPDFK;
					$lineBox[$k]['boxtop'] = $topy - $ypos[$k]['boxtop'];
					$lineBox[$k]['boxbottom'] = $topy - $ypos[$k]['boxbottom'];
					$lineBox[$k]['glyphYorigin'] = $topy - $ypos[$k]['glyphYorigin'];
					$lineBox[$k]['baseline-shift'] = 0;
					// continue;
				}
				$va = $this->objectbuffer[$k]['vertical-align']; // = $objattr['vertical-align'] = set as M,T,B,S

				if ($va == 'BS') { //  (BASELINE default)
					$lineBox[$k]['top'] = $lineBox[-1]['glyphYorigin'] - $oh;
				} elseif ($va == 'M') {
					$lineBox[$k]['top'] = $midpoint - $oh / 2;
				} elseif ($va == 'TT') {
					$lineBox[$k]['top'] = $lineBox[-1]['boxtop'];
				} elseif ($va == 'TB') {
					$lineBox[$k]['top'] = $lineBox[-1]['boxbottom'] - $oh;
				} elseif ($va == 'T') {
					$lineBox[$k]['top'] = 0;
				} elseif ($va == 'B') {
					$lineBox[$k]['top'] = $stackHeight - $oh;
				}
			} elseif ($content[$k] || $content[$k] === '0') {
				$lineBox[$k]['boxtop'] = $topy - $ypos[$k]['boxtop'];
				$lineBox[$k]['boxbottom'] = $topy - $ypos[$k]['boxbottom'];
				// $lineBox[$k]['exttop'] = $topy - $ypos[$k]['exttop'];
				// $lineBox[$k]['extbottom'] = $topy - $ypos[$k]['extbottom'];
				$lineBox[$k]['glyphYorigin'] = $topy - $ypos[$k]['glyphYorigin'];
				$lineBox[$k]['baseline-shift'] = $ypos[$k]['baseline-shift'];
				if (isset($bordypos[$k]['boxtop'])) {
					$lineBox[$k]['border-boxtop'] = $topy - $bordypos[$k]['boxtop'];
					$lineBox[$k]['border-boxbottom'] = $topy - $bordypos[$k]['boxbottom'];
					$lineBox[$k]['border-baseline-shift'] = $bordypos[$k]['baseline-shift'];
				}
				if (isset($bgypos[$k]['boxtop'])) {
					$lineBox[$k]['background-boxtop'] = $topy - $bgypos[$k]['boxtop'];
					$lineBox[$k]['background-boxbottom'] = $topy - $bgypos[$k]['boxbottom'];
					$lineBox[$k]['background-baseline-shift'] = $bgypos[$k]['baseline-shift'];
				}
			}
		}
	}

	function SetBasePath($str = '')
	{
		if (isset($_SERVER['HTTP_HOST'])) {
			$host = $_SERVER['HTTP_HOST'];
		} elseif (isset($_SERVER['SERVER_NAME'])) {
			$host = $_SERVER['SERVER_NAME'];
		} else {
			$host = '';
		}
		if (!$str) {
			if ($_SERVER['SCRIPT_NAME']) {
				$currentPath = dirname($_SERVER['SCRIPT_NAME']);
			} else {
				$currentPath = dirname($_SERVER['PHP_SELF']);
			}
			$currentPath = str_replace("\\", "/", $currentPath);
			if ($currentPath == '/') {
				$currentPath = '';
			}
			if ($host) {  // mPDF 6
				if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']) {
					$currpath = 'https://' . $host . $currentPath . '/';
				} else {
					$currpath = 'http://' . $host . $currentPath . '/';
				}
			} else {
				$currpath = '';
			}
			$this->basepath = $currpath;
			$this->basepathIsLocal = true;
			return;
		}
		$str = preg_replace('/\?.*/', '', $str);
		if (!preg_match('/(http|https|ftp):\/\/.*\//i', $str)) {
			$str .= '/';
		}
		$str .= 'xxx'; // in case $str ends in / e.g. http://www.bbc.co.uk/
		$this->basepath = dirname($str) . "/"; // returns e.g. e.g. http://www.google.com/dir1/dir2/dir3/
		$this->basepath = str_replace("\\", "/", $this->basepath); //If on Windows
		$tr = parse_url($this->basepath);
		if (isset($tr['host']) && ($tr['host'] == $host)) {
			$this->basepathIsLocal = true;
		} else {
			$this->basepathIsLocal = false;
		}
	}

	function GetFullPath(&$path, $basepath = '')
	{
		// When parsing CSS need to pass temporary basepath - so links are relative to current stylesheet
		if (!$basepath) {
			$basepath = $this->basepath;
		}
		//Fix path value
		$path = str_replace("\\", "/", $path); //If on Windows
		// mPDF 5.7.2
		if (substr($path, 0, 2) == "//") {
			$tr = parse_url($basepath);
			$path = $tr['scheme'] . ':' . $path; // mPDF 6
		}

		$regexp = '|^./|'; // Inadvertently corrects "./path/etc" and "//www.domain.com/etc"
		$path = preg_replace($regexp, '', $path);

		if (substr($path, 0, 1) == '#') {
			return;
		}
		if (preg_match('@^(mailto|tel|fax):.*@i', $path)) {
			return;
		}
		if (substr($path, 0, 3) == "../") { //It is a Relative Link
			$backtrackamount = substr_count($path, "../");
			$maxbacktrack = substr_count($basepath, "/") - 3;
			$filepath = str_replace("../", '', $path);
			$path = $basepath;
			//If it is an invalid relative link, then make it go to directory root
			if ($backtrackamount > $maxbacktrack)
				$backtrackamount = $maxbacktrack;
			//Backtrack some directories
			for ($i = 0; $i < $backtrackamount + 1; $i++)
				$path = substr($path, 0, strrpos($path, "/"));
			$path = $path . "/" . $filepath; //Make it an absolute path
		}
		elseif (strpos($path, ":/") === false || strpos($path, ":/") > 10) { //It is a Local Link
			if (substr($path, 0, 1) == "/") {
				$tr = parse_url($basepath);
				// mPDF 5.7.2
				$root = '';
				if (!empty($tr['scheme'])) {
					$root .= $tr['scheme'] . '://';
				}
				$root .= isset($tr['host']) ? $tr['host'] : '';
				$root .= ((isset($tr['port']) && $tr['port']) ? (':' . $tr['port']) : ''); // mPDF 5.7.3
				$path = $root . $path;
			} else {
				$path = $basepath . $path;
			}
		}
		//Do nothing if it is an Absolute Link
	}

	// Used for external CSS files
	function _get_file($path)
	{
		// If local file try using local path (? quicker, but also allowed even if allow_url_fopen false)
		$contents = '';
		// mPDF 5.7.3
		if (strpos($path, "//") === false) {
			$path = preg_replace('/\.css\?.*$/', '.css', $path);
		}
		$contents = @file_get_contents($path);
		if ($contents) {
			return $contents;
		}
		if ($this->basepathIsLocal) {
			$tr = parse_url($path);
			$lp = getenv("SCRIPT_NAME");
			$ap = realpath($lp);
			$ap = str_replace("\\", "/", $ap);
			$docroot = substr($ap, 0, strpos($ap, $lp));
			// WriteHTML parses all paths to full URLs; may be local file name
			if ($tr['scheme'] && $tr['host'] && $_SERVER["DOCUMENT_ROOT"]) {
				$localpath = $_SERVER["DOCUMENT_ROOT"] . $tr['path'];
			}
			// DOCUMENT_ROOT is not returned on IIS
			elseif ($docroot) {
				$localpath = $docroot . $tr['path'];
			} else {
				$localpath = $path;
			}
			$contents = @file_get_contents($localpath);
		}
		// if not use full URL
		elseif (!$contents && !ini_get('allow_url_fopen') && function_exists("curl_init")) {
			$ch = curl_init($path);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			$contents = curl_exec($ch);
			curl_close($ch);
		}
		return $contents;
	}

	function docPageNum($num = 0, $extras = false)
	{
		if ($num < 1) {
			$num = $this->page;
		}
		$type = $this->defaultPageNumStyle; // set default Page Number Style
		$ppgno = $num;
		$suppress = 0;
		$offset = 0;
		$lastreset = 0;
		foreach ($this->PageNumSubstitutions AS $psarr) {
			if ($num >= $psarr['from']) {
				if ($psarr['reset']) {
					if ($psarr['reset'] > 1) {
						$offset = $psarr['reset'] - 1;
					}
					$ppgno = $num - $psarr['from'] + 1 + $offset;
					$lastreset = $psarr['from'];
				}
				if ($psarr['type']) {
					$type = $psarr['type'];
				}
				if (strtoupper($psarr['suppress']) == 'ON' || $psarr['suppress'] == 1) {
					$suppress = 1;
				} elseif (strtoupper($psarr['suppress']) == 'OFF') {
					$suppress = 0;
				}
			}
		}
		if ($suppress) {
			return '';
		}

		$ppgno = $this->_getStyledNumber($ppgno, $type);
		if ($extras) {
			$ppgno = $this->pagenumPrefix . $ppgno . $this->pagenumSuffix;
		}
		return $ppgno;
	}

	function docPageNumTotal($num = 0, $extras = false)
	{
		if ($num < 1) {
			$num = $this->page;
		}
		$type = $this->defaultPageNumStyle; // set default Page Number Style
		$ppgstart = 1;
		$ppgend = count($this->pages) + 1;
		$suppress = 0;
		$offset = 0;
		foreach ($this->PageNumSubstitutions AS $psarr) {
			if ($num >= $psarr['from']) {
				if ($psarr['reset']) {
					if ($psarr['reset'] > 1) {
						$offset = $psarr['reset'] - 1;
					}
					$ppgstart = $psarr['from'] + $offset;
					$ppgend = count($this->pages) + 1 + $offset;
				}
				if ($psarr['type']) {
					$type = $psarr['type'];
				}
				if (strtoupper($psarr['suppress']) == 'ON' || $psarr['suppress'] == 1) {
					$suppress = 1;
				} elseif (strtoupper($psarr['suppress']) == 'OFF') {
					$suppress = 0;
				}
			}
			if ($num < $psarr['from']) {
				if ($psarr['reset']) {
					$ppgend = $psarr['from'] + $offset;
					break;
				}
			}
		}
		if ($suppress) {
			return '';
		}
		$ppgno = $ppgend - $ppgstart + $offset;

		$ppgno = $this->_getStyledNumber($ppgno, $type);
		if ($extras) {
			$ppgno = $this->pagenumPrefix . $ppgno . $this->pagenumSuffix;
		}
		return $ppgno;
	}

	// mPDF 6
	function _getStyledNumber($ppgno, $type, $listmarker = false)
	{
		if ($listmarker) {
			$reverse = true;   // Reverse RTL numerals (Hebrew) when using for list
			$checkfont = true; // Using list - font is set, so check if character is available
		} else {
			$reverse = false;  // For pagenumbers, RTL numerals (Hebrew) will get reversed later by bidi
			$checkfont = false; // For pagenumbers - font is not set, so no check
		}
		$lowertype = strtolower($type);
		if ($lowertype == 'upper-latin' || $lowertype == 'upper-alpha' || $type == 'A') {
			$ppgno = $this->dec2alpha($ppgno, true);
		} elseif ($lowertype == 'lower-latin' || $lowertype == 'lower-alpha' || $type == 'a') {
			$ppgno = $this->dec2alpha($ppgno, false);
		} elseif ($lowertype == 'upper-roman' || $type == 'I') {
			$ppgno = $this->dec2roman($ppgno, true);
		} elseif ($lowertype == 'lower-roman' || $type == 'i') {
			$ppgno = $this->dec2roman($ppgno, false);
		} elseif ($lowertype == 'hebrew') {
			$ppgno = $this->dec2hebrew($ppgno, $reverse);
		} elseif (preg_match('/(arabic-indic|bengali|devanagari|gujarati|gurmukhi|kannada|malayalam|oriya|persian|tamil|telugu|thai|urdu|cambodian|khmer|lao)/i', $lowertype, $m)) {
			switch ($m[1]) { //Format type
				case 'arabic-indic': $cp = 0x0660;
					break;
				case 'persian':
				case 'urdu': $cp = 0x06F0;
					break;
				case 'bengali': $cp = 0x09E6;
					break;
				case 'devanagari': $cp = 0x0966;
					break;
				case 'gujarati': $cp = 0x0AE6;
					break;
				case 'gurmukhi': $cp = 0x0A66;
					break;
				case 'kannada': $cp = 0x0CE6;
					break;
				case 'malayalam': $cp = 0x0D66;
					break;
				case 'oriya': $cp = 0x0B66;
					break;
				case 'telugu': $cp = 0x0C66;
					break;
				case 'tamil': $cp = 0x0BE6;
					break;
				case 'thai': $cp = 0x0E50;
					break;
				case 'khmer':
				case 'cambodian': $cp = 0x17E0;
					break;
				case 'lao': $cp = 0x0ED0;
					break;
			}
			$ppgno = $this->dec2other($ppgno, $cp, $checkfont);
		} elseif ($lowertype == 'cjk-decimal') {
			$ppgno = $this->dec2cjk($ppgno);
		}
		return $ppgno;
	}

	function docPageSettings($num = 0)
	{
		// Returns current type (numberstyle), suppression state for this page number;
		// reset is only returned if set for this page number
		if ($num < 1) {
			$num = $this->page;
		}
		$type = $this->defaultPageNumStyle; // set default Page Number Style
		$ppgno = $num;
		$suppress = 0;
		$offset = 0;
		$reset = '';
		foreach ($this->PageNumSubstitutions AS $psarr) {
			if ($num >= $psarr['from']) {
				if ($psarr['reset']) {
					if ($psarr['reset'] > 1) {
						$offset = $psarr['reset'] - 1;
					}
					$ppgno = $num - $psarr['from'] + 1 + $offset;
				}
				if ($psarr['type']) {
					$type = $psarr['type'];
				}
				if (strtoupper($psarr['suppress']) == 'ON' || $psarr['suppress'] == 1) {
					$suppress = 1;
				} elseif (strtoupper($psarr['suppress']) == 'OFF') {
					$suppress = 0;
				}
			}
			if ($num == $psarr['from']) {
				$reset = $psarr['reset'];
			}
		}
		if ($suppress) {
			$suppress = 'on';
		} else {
			$suppress = 'off';
		}
		return array($type, $suppress, $reset);
	}

	function RestartDocTemplate()
	{
		$this->docTemplateStart = $this->page;
	}

	//Page header
	function Header($content = '')
	{

		$this->cMarginL = 0;
		$this->cMarginR = 0;


		if (($this->mirrorMargins && ($this->page % 2 == 0) && $this->HTMLHeaderE) || ($this->mirrorMargins && ($this->page % 2 == 1) && $this->HTMLHeader) || (!$this->mirrorMargins && $this->HTMLHeader)) {
			$this->writeHTMLHeaders();
			return;
		}
	}

	/* -- TABLES -- */

	function TableHeaderFooter($content = '', $tablestartpage = '', $tablestartcolumn = '', $horf = 'H', $level, $firstSpread = true, $finalSpread = true)
	{
		if (($horf == 'H' || $horf == 'F') && !empty($content)) { // mPDF 5.7.2
			$table = &$this->table[1][1];

			// mPDF 5.7.2
			if ($horf == 'F') { // Table Footer
				$firstrow = count($table['cells']) - $table['footernrows'];
				$lastrow = count($table['cells']) - 1;
			} else {  // Table Header
				$firstrow = 0;
				$lastrow = $table['headernrows'] - 1;
			}
			if (empty($content[$firstrow])) {
				if ($this->debug) {
					throw new MpdfException("&lt;tfoot&gt; must precede &lt;tbody&gt; in a table");
				} else {
					return;
				}
			}


			// Advance down page by half width of top border
			if ($horf == 'H') { // Only if header
				if ($table['borders_separate']) {
					$adv = $table['border_spacing_V'] / 2 + $table['border_details']['T']['w'] + $table['padding']['T'];
				} else {
					$adv = $table['max_cell_border_width']['T'] / 2;
				}
				if ($adv) {
					if ($this->table_rotate) {
						$this->y += ($adv);
					} else {
						$this->DivLn($adv, $this->blklvl, true);
					}
				}
			}

			$topy = $content[$firstrow][0]['y'] - $this->y;

			for ($i = $firstrow; $i <= $lastrow; $i++) {

				$y = $this->y;

				/* -- COLUMNS -- */
				// If outside columns, this is done in PaintDivBB
				if ($this->ColActive) {
					//OUTER FILL BGCOLOR of DIVS
					if ($this->blklvl > 0) {
						$firstblockfill = $this->GetFirstBlockFill();
						if ($firstblockfill && $this->blklvl >= $firstblockfill) {
							$divh = $content[$i][0]['h'];
							$bak_x = $this->x;
							$this->DivLn($divh, -3, false);
							// Reset current block fill
							$bcor = $this->blk[$this->blklvl]['bgcolorarray'];
							$this->SetFColor($bcor);
							$this->x = $bak_x;
						}
					}
				}
				/* -- END COLUMNS -- */

				$colctr = 0;
				foreach ($content[$i] as $tablehf) {
					$colctr++;
					$y = $tablehf['y'] - $topy;
					$this->y = $y;
					//Set some cell values
					$x = $tablehf['x'];
					if (($this->mirrorMargins) && ($tablestartpage == 'ODD') && (($this->page) % 2 == 0)) { // EVEN
						$x = $x + $this->MarginCorrection;
					} elseif (($this->mirrorMargins) && ($tablestartpage == 'EVEN') && (($this->page) % 2 == 1)) { // ODD
						$x = $x + $this->MarginCorrection;
					}
					/* -- COLUMNS -- */
					// Added to correct for Columns
					if ($this->ColActive) {
						if ($this->directionality == 'rtl') { // *OTL*
							$x -= ($this->CurrCol - $tablestartcolumn) * ($this->ColWidth + $this->ColGap); // *OTL*
						} // *OTL*
						else { // *OTL*
							$x += ($this->CurrCol - $tablestartcolumn) * ($this->ColWidth + $this->ColGap);
						} // *OTL*
					}
					/* -- END COLUMNS -- */

					if ($colctr == 1) {
						$x0 = $x;
					}

					// mPDF ITERATION
					if ($this->iterationCounter) {
						foreach ($tablehf['textbuffer'] AS $k => $t) {
							if (!is_array($t[0]) && preg_match('/{iteration ([a-zA-Z0-9_]+)}/', $t[0], $m)) {
								$vname = '__' . $m[1] . '_';
								if (!isset($this->$vname)) {
									$this->$vname = 1;
								} else {
									$this->$vname++;
								}
								$tablehf['textbuffer'][$k][0] = preg_replace('/{iteration ' . $m[1] . '}/', $this->$vname, $tablehf['textbuffer'][$k][0]);
							}
						}
					}

					$w = $tablehf['w'];
					$h = $tablehf['h'];
					$va = $tablehf['va'];
					$R = $tablehf['R'];
					$direction = $tablehf['direction'];
					$mih = $tablehf['mih'];
					$border = $tablehf['border'];
					$border_details = $tablehf['border_details'];
					$padding = $tablehf['padding'];
					$this->tabletheadjustfinished = true;

					$textbuffer = $tablehf['textbuffer'];

					//Align
					$align = $tablehf['a'];
					$this->cellTextAlign = $align;

					$this->cellLineHeight = $tablehf['cellLineHeight'];
					$this->cellLineStackingStrategy = $tablehf['cellLineStackingStrategy'];
					$this->cellLineStackingShift = $tablehf['cellLineStackingShift'];

					$this->x = $x;

					if ($this->ColActive) {
						if ($table['borders_separate']) {
							$tablefill = isset($table['bgcolor'][-1]) ? $table['bgcolor'][-1] : 0;
							if ($tablefill) {
								$color = $this->ConvertColor($tablefill);
								if ($color) {
									$xadj = ($table['border_spacing_H'] / 2);
									$yadj = ($table['border_spacing_V'] / 2);
									$wadj = $table['border_spacing_H'];
									$hadj = $table['border_spacing_V'];
									if ($i == $firstrow && $horf == 'H') {  // Top
										$yadj += $table['padding']['T'] + $table['border_details']['T']['w'];
										$hadj += $table['padding']['T'] + $table['border_details']['T']['w'];
									}
									if (($i == ($lastrow) || (isset($tablehf['rowspan']) && ($i + $tablehf['rowspan']) == ($lastrow + 1)) || (!isset($tablehf['rowspan']) && ($i + 1) == ($lastrow + 1))) && $horf == 'F') { // Bottom
										$hadj += $table['padding']['B'] + $table['border_details']['B']['w'];
									}
									if ($colctr == 1) {  // Left
										$xadj += $table['padding']['L'] + $table['border_details']['L']['w'];
										$wadj += $table['padding']['L'] + $table['border_details']['L']['w'];
									}
									if ($colctr == count($content[$i])) { // Right
										$wadj += $table['padding']['R'] + $table['border_details']['R']['w'];
									}
									$this->SetFColor($color);
									$this->Rect($x - $xadj, $y - $yadj, $w + $wadj, $h + $hadj, 'F');
								}
							}
						}
					}

					if ($table['empty_cells'] != 'hide' || !empty($textbuffer) || !$table['borders_separate']) {
						$paintcell = true;
					} else {
						$paintcell = false;
					}

					//Vertical align
					if ($R && INTVAL($R) > 0 && isset($va) && $va != 'B') {
						$va = 'B';
					}

					if (!isset($va) || empty($va) || $va == 'M')
						$this->y += ($h - $mih) / 2;
					elseif (isset($va) && $va == 'B')
						$this->y += $h - $mih;


					//TABLE ROW OR CELL FILL BGCOLOR
					$fill = 0;
					if (isset($tablehf['bgcolor']) && $tablehf['bgcolor'] && $tablehf['bgcolor'] != 'transparent') {
						$fill = $tablehf['bgcolor'];
						$leveladj = 6;
					} elseif (isset($content[$i][0]['trbgcolor']) && $content[$i][0]['trbgcolor'] && $content[$i][0]['trbgcolor'] != 'transparent') { // Row color
						$fill = $content[$i][0]['trbgcolor'];
						$leveladj = 3;
					}
					if ($fill && $paintcell) {
						$color = $this->ConvertColor($fill);
						if ($color) {
							if ($table['borders_separate']) {
								if ($this->ColActive) {
									$this->SetFColor($color);
									$this->Rect($x + ($table['border_spacing_H'] / 2), $y + ($table['border_spacing_V'] / 2), $w - $table['border_spacing_H'], $h - $table['border_spacing_V'], 'F');
								} else {
									$this->tableBackgrounds[$level * 9 + $leveladj][] = array('gradient' => false, 'x' => ($x + ($table['border_spacing_H'] / 2)), 'y' => ($y + ($table['border_spacing_V'] / 2)), 'w' => ($w - $table['border_spacing_H']), 'h' => ($h - $table['border_spacing_V']), 'col' => $color);
								}
							} else {
								if ($this->ColActive) {
									$this->SetFColor($color);
									$this->Rect($x, $y, $w, $h, 'F');
								} else {
									$this->tableBackgrounds[$level * 9 + $leveladj][] = array('gradient' => false, 'x' => $x, 'y' => $y, 'w' => $w, 'h' => $h, 'col' => $color);
								}
							}
						}
					}


					/* -- BACKGROUNDS -- */
					if (isset($tablehf['gradient']) && $tablehf['gradient'] && $paintcell) {
						$g = $this->grad->parseBackgroundGradient($tablehf['gradient']);
						if ($g) {
							if ($table['borders_separate']) {
								$px = $x + ($table['border_spacing_H'] / 2);
								$py = $y + ($table['border_spacing_V'] / 2);
								$pw = $w - $table['border_spacing_H'];
								$ph = $h - $table['border_spacing_V'];
							} else {
								$px = $x;
								$py = $y;
								$pw = $w;
								$ph = $h;
							}
							if ($this->ColActive) {
								$this->grad->Gradient($px, $py, $pw, $ph, $g['type'], $g['stops'], $g['colorspace'], $g['coords'], $g['extend']);
							} else {
								$this->tableBackgrounds[$level * 9 + 7][] = array('gradient' => true, 'x' => $px, 'y' => $py, 'w' => $pw, 'h' => $ph, 'gradtype' => $g['type'], 'stops' => $g['stops'], 'colorspace' => $g['colorspace'], 'coords' => $g['coords'], 'extend' => $g['extend'], 'clippath' => '');
							}
						}
					}

					if (isset($tablehf['background-image']) && $paintcell) {
						if ($tablehf['background-image']['gradient'] && preg_match('/(-moz-)*(repeating-)*(linear|radial)-gradient/', $tablehf['background-image']['gradient'])) {
							$g = $this->grad->parseMozGradient($tablehf['background-image']['gradient']);
							if ($g) {
								if ($table['borders_separate']) {
									$px = $x + ($table['border_spacing_H'] / 2);
									$py = $y + ($table['border_spacing_V'] / 2);
									$pw = $w - $table['border_spacing_H'];
									$ph = $h - $table['border_spacing_V'];
								} else {
									$px = $x;
									$py = $y;
									$pw = $w;
									$ph = $h;
								}
								if ($this->ColActive) {
									$this->grad->Gradient($px, $py, $pw, $ph, $g['type'], $g['stops'], $g['colorspace'], $g['coords'], $g['extend']);
								} else {
									$this->tableBackgrounds[$level * 9 + 7][] = array('gradient' => true, 'x' => $px, 'y' => $py, 'w' => $pw, 'h' => $ph, 'gradtype' => $g['type'], 'stops' => $g['stops'], 'colorspace' => $g['colorspace'], 'coords' => $g['coords'], 'extend' => $g['extend'], 'clippath' => '');
								}
							}
						} elseif ($tablehf['background-image']['image_id']) { // Background pattern
							$n = count($this->patterns) + 1;
							if ($table['borders_separate']) {
								$px = $x + ($table['border_spacing_H'] / 2);
								$py = $y + ($table['border_spacing_V'] / 2);
								$pw = $w - $table['border_spacing_H'];
								$ph = $h - $table['border_spacing_V'];
							} else {
								$px = $x;
								$py = $y;
								$pw = $w;
								$ph = $h;
							}
							if ($this->ColActive) {
								list($orig_w, $orig_h, $x_repeat, $y_repeat) = $this->_resizeBackgroundImage($tablehf['background-image']['orig_w'], $tablehf['background-image']['orig_h'], $pw, $ph, $tablehf['background-image']['resize'], $tablehf['background-image']['x_repeat'], $tablehf['background-image']['y_repeat']);
								$this->patterns[$n] = array('x' => $px, 'y' => $py, 'w' => $pw, 'h' => $ph, 'pgh' => $this->h, 'image_id' => $tablehf['background-image']['image_id'], 'orig_w' => $orig_w, 'orig_h' => $orig_h, 'x_pos' => $tablehf['background-image']['x_pos'], 'y_pos' => $tablehf['background-image']['y_pos'], 'x_repeat' => $x_repeat, 'y_repeat' => $y_repeat, 'itype' => $tablehf['background-image']['itype']);
								if ($tablehf['background-image']['opacity'] > 0 && $tablehf['background-image']['opacity'] < 1) {
									$opac = $this->SetAlpha($tablehf['background-image']['opacity'], 'Normal', true);
								} else {
									$opac = '';
								}
								$this->_out(sprintf('q /Pattern cs /P%d scn %s %.3F %.3F %.3F %.3F re f Q', $n, $opac, $px * _MPDFK, ($this->h - $py) * _MPDFK, $pw * _MPDFK, -$ph * _MPDFK));
							} else {
								$this->tableBackgrounds[$level * 9 + 8][] = array('x' => $px, 'y' => $py, 'w' => $pw, 'h' => $ph, 'image_id' => $tablehf['background-image']['image_id'], 'orig_w' => $tablehf['background-image']['orig_w'], 'orig_h' => $tablehf['background-image']['orig_h'], 'x_pos' => $tablehf['background-image']['x_pos'], 'y_pos' => $tablehf['background-image']['y_pos'], 'x_repeat' => $tablehf['background-image']['x_repeat'], 'y_repeat' => $tablehf['background-image']['y_repeat'], 'clippath' => '', 'resize' => $tablehf['background-image']['resize'], 'opacity' => $tablehf['background-image']['opacity'], 'itype' => $tablehf['background-image']['itype']);
							}
						}
					}
					/* -- END BACKGROUNDS -- */

					//Cell Border
					if ($table['borders_separate'] && $paintcell && $border) {
						$this->_tableRect($x + ($table['border_spacing_H'] / 2) + ($border_details['L']['w'] / 2), $y + ($table['border_spacing_V'] / 2) + ($border_details['T']['w'] / 2), $w - $table['border_spacing_H'] - ($border_details['L']['w'] / 2) - ($border_details['R']['w'] / 2), $h - $table['border_spacing_V'] - ($border_details['T']['w'] / 2) - ($border_details['B']['w'] / 2), $border, $border_details, false, $table['borders_separate']);
					} elseif ($paintcell && $border) {
						$this->_tableRect($x, $y, $w, $h, $border, $border_details, true, $table['borders_separate']);   // true causes buffer
					}

					//Print cell content
					if (!empty($textbuffer)) {
						if ($horf == 'F' && preg_match('/{colsum([0-9]*)[_]*}/', $textbuffer[0][0], $m)) {
							$rep = sprintf("%01." . intval($m[1]) . "f", $this->colsums[$colctr - 1]);
							$textbuffer[0][0] = preg_replace('/{colsum[0-9_]*}/', $