# wp-team-member-dynamic-cards
A WordPress solution for dynamically generating team member cards from custom fields, with pagination, alphabetical sorting, and smooth anchor linking. Includes a system to automatically link course pages to individual team members’ profiles.

This project provides a flexible system for managing and displaying team member profiles, such as course leads, using a custom field setup in WordPress. The system was designed for projects where administrators are already familiar with native custom fields and need a solution that allows team members to be reused across multiple pages. Each team member’s profile includes basic information such as name, subtitle, description, and a photo. The system ensures a smooth user experience by generating links that can navigate to the correct page and scroll directly to a specific member card on the main team page.

The main team page dynamically generates cards for each member, supporting pagination and alphabetically sorted listings. Each card includes a “Read More” section that reveals additional information, and each card has a unique ID to facilitate anchor linking from other pages. On course pages, a custom field can reference a specific team member, automatically fetching their info from the team page and generating a course lead card with the relevant image, name, subtitle, and description. The system also dynamically generates a URL for the “View Full Profile” button that directs the user back to the team page, activates the correct pagination, and scrolls smoothly to the corresponding member card.

The system was built to accommodate up to 100 team member profiles while maintaining simplicity and ease of reuse. Team member images are automatically located based on a naming convention in the uploads folder, with a fallback to a placeholder image if necessary. For public or shared code, all PHP and JavaScript class names, IDs, and custom field keys are abstracted to neutral placeholder names, and the HTML structure has been simplified to focus on core functionality rather than styling.

Features

Dynamically generates team member cards with pagination on the team page.
Supports up to 100 members with custom fields for name, subtitle, description, and image.
Generates course lead cards on course pages by referencing team members.
Links from course pages back to the correct team page and card using smooth scrolling.
Sorts cards alphabetically and assigns unique IDs for anchor links.
Dynamically handles images with a fallback to placeholders.
