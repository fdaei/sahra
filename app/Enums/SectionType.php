<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

/**
 * Identifies which Figma section a PageSection represents.
 *
 * Every case maps to a concrete section in the audit (docs/FIGMA-AUDIT.md §5).
 * The frontend switches on this value to pick the matching Vue component, so
 * adding a case here without a component is a no-op rather than a crash.
 */
enum SectionType: string implements HasLabel
{
    // Home — Figma 1419:9192
    case Hero = 'hero';                     // 1419:9194
    case Kpi = 'kpi';                       // 1419:9318
    case TrustProof = 'trust_proof';        // 1419:9205
    case ServicesCloud = 'services_cloud';  // 1419:9279
    case LeadMagnet = 'lead_magnet';        // 1419:9322
    case ProjectsShowcase = 'projects_showcase'; // 1419:9216
    case Process = 'process';               // 1419:9302
    case Packages = 'packages';             // 1419:9323
    case WhyUs = 'why_us';                  // 1419:9230
    case Reviews = 'reviews';               // 1419:9243
    case Insights = 'insights';             // 1419:9258
    case Faq = 'faq';                       // 1419:9272

    // Global — reused across pages
    case FinalCta = 'final_cta';            // 1419:9333

    // About — Figma 908:1576
    case AboutHero = 'about_hero';
    case Story = 'story';
    case HowWeThink = 'how_we_think';
    case Team = 'team';

    // Single project — Figma 1323:7541
    case Challenge = 'challenge';
    case Goals = 'goals';
    case Strategy = 'strategy';
    case Deliverables = 'deliverables';
    case Showcase = 'showcase';
    case Results = 'results';

    // Legal / rich-text pages
    case RichText = 'rich_text';

    public function getLabel(): string
    {
        return str(ucwords(str_replace('_', ' ', $this->value)))->toString();
    }

    /**
     * Does this section hold repeatable child items (SectionItem rows)?
     */
    public function hasItems(): bool
    {
        return in_array($this, [
            self::Kpi,
            self::Process,
            self::Packages,
            self::WhyUs,
            self::HowWeThink,
            self::Goals,
            self::Strategy,
            self::Deliverables,
            self::Results,
        ], true);
    }

    /**
     * @return array<string, string>
     */
    public static function options(): array
    {
        return array_reduce(
            self::cases(),
            fn (array $carry, self $case): array => $carry + [$case->value => $case->getLabel()],
            [],
        );
    }
}
