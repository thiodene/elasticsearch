<?php
// app > Http > Resources > ElasticApi.php
namespace App\Http\Resources;

date_default_timezone_set("America/Toronto");

use Illuminate\Support\Str;
use Illuminate\Http\Resources\Json\JsonResource;
use Session;

use App\Http\Resources\PartnerMinistryApi;
use App\Http\Resources\TopicApi;
use App\Release;
use App\ReleaseSection;
use App\ReleaseUserPermission;

class ElasticApi extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
    
        #######################################################################################################
        # DETERMINE LANGUAGE
        ####################################################################################################

        // Has release section been filtered by language
        if ($this->language == "fr")
        {
            $language_flag = 0;
            $language_flag_opposite = 1;
        }
        else // default to English
        {
            $language_flag = 1;
            $language_flag_opposite = 0;
        }

        #######################################################################################################
        # SUPPORT RESOURCES
        #######################################################################################################

        // Lead is the first p tag
        $content_lead = explode("</p>", $this->get_section_content('content_body', $language_flag))[0] . "</p>";
        $content_lead = $content_lead == "</p>" ? null : $content_lead;
        // Body is the absence of the lead
        $content_body = str_replace($content_lead, null, $this->get_section_content('content_body', $language_flag)) ?? $this->get_section_content('content_body', $language_flag);

        // Get ministries (lead and partners)
        $lead_ministry = $this->lead_ministry->first();

        // Get title
        $title = $this->get_section_content('content_title', $language_flag);
        $title_opposite = $this->get_section_content('content_title', $language_flag_opposite);

        // Get statuses
        $status = $this->statuses->first() ? $this->statuses->first() : null;

        // Get owners (users in this system) except we do not need administrator, the original creator, and the current user
        $owners = $this->users->whereNotIn("id", [1, $this->creator->first()->id, intval(Session::get("user")["id"])])->flatten();

        // use $this->whenLoaded() whenever appropriate
        return [
            'id'                                => $this->id,   
            'contacts'                          => $this->get_section_content('contacts', $language_flag), 
            'content_title'                     => $title,
            'content_subtitle'                  => $this->get_section_content('content_subtitle', $language_flag), // TODO - lead should be renamed across the board to subtitle
            'content_lead'                      => $content_lead,
            'content_body'                      => $content_body,
            'keywords'                          => implode(";", $this->tags->pluck('name')->toArray()),
            'language'                          => $this->language ?? "en",
            'ministry_id'                       => $lead_ministry->id,
            'ministry_acronym'                  => $lead_ministry->acronym,
            'ministry_name'                     => $lead_ministry->name,
            'ministry_abbreviated'              => $lead_ministry->name_abbreviated,
            'quickfacts'                        => $this->get_section_content('quick_facts', $language_flag),
            'release_date_time'                 => $this->statuses->first()->status_date_time ?? null,
            'release_date_time_formatted'       => date('F j, Y', strtotime($this->statuses->first()->status_date_time)),
            'release_id_translated'             => $this->id,
            'release_type_id'                   => $this->release_type->id,
            'release_type_name'                 => $language_flag ? $this->release_type->name : $this->release_type->name_fr,
            'release_type_label'                => $this->release_type->label,
            'release_resources'                 => $this->get_section_content('resources', $language_flag),
            'slug'                              => Str::slug($title, '-'),
            'status_type_id'                    => $status->status_type_id ?? null,
            // 'tags'                              => $this->tags->map(function ($item, $key) {
            //                                           return (object) [
            //                                             "label" => $item->name,
            //                                             "value" => $item->id,
            //                                           ];
            //                                         }),
            'topics'                            => $this->topics->map(function ($item, $key) use ($language_flag) {
                                                      return (object) [
                                                        "label" => $language_flag == 1 ? $item->name : $item->name_fr,
                                                        "description" => $language_flag == 1 ? $item->description : $item->description_fr,
                                                        "value" => $item->id,
                                                      ];
                                                    }),
            'unformatted_slug'                  => Str::slug($title, '_'),
            'unformatted_slug_translated'       => Str::slug($title_opposite, '_'),
            'release_distribution_id'           => $this->statuses->first()->distribution_type_id ?? null,
            'release_language_distribution'     => $this->statuses->first()->distribution_language_type_id ?? null,
        ];

    }

    /**
     * Grab specific section content.
     * 
     * returns specific content value to a release
     */
    public function get_section_content($label, $language_flag)
    {

        $section = $this->release_sections->where('english_flag', $language_flag)->where('section.label', $label)->first();

        if ($section != NULL)
        {
            return $section->content;
        }
        else
        {
            return NULL;
        }
        
    }

    /**
     * Grab specific section children.
     * 
     * returns specific children to a release
     */
    public function get_section_children_content($parent_label, $child_label, $language_flag)
    {

        $section = $this->release_sections->where('english_flag', $language_flag)->where('section.label', $parent_label)->first();

        if ($section != NULL)
        {

            $section_children = $section->children->where('section.label', $child_label)->first();

            if ($section_children != NULL)
            {

                return $section_children->content;

            }

        }
        else
        {

            return NULL;
            
        }
        
    }

    /**
     * Grab specific quotes.
     * 
     * returns specific quotes to a release
     */
    public function get_section_quotes($section_quotes)
    {

        $section_quotes = json_decode($section_quotes);

        $quotes = array();
        if ($section_quotes) 
        {
          foreach($section_quotes as $section_quote)
          {
              $quote = array( 
                  'author_name' => $section_quote->quote_author,
                  'content' => $section_quote->quote,
                  'title' => $section_quote->quote_author_title,
              );
              $quotes[] = $quote;
          }
        }

        return $quotes;

    }

}
