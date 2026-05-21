# Skills card block

`block_skillscard` is a Moodle block that displays a user's completed competency/course-related records as a compact block on Moodle pages. In the Moodle UI the block title is shown as **Skills card**.

The block reads Moodle competency data for the current user and lists the competency short names available for that user. If no records are found, the block displays the configured "No competencies" message.

## Requirements

* Moodle `2022041200` or later.
* Moodle competency data must exist for users before the block can display completed course/competency entries.
* The plugin must be installed in `blocks/skillscard`.

## Installation

1. Copy this plugin directory to your Moodle installation as:

   ```text
   blocks/skillscard
   ```

2. Visit **Site administration > Notifications** or run the Moodle CLI upgrade:

   ```bash
   php admin/cli/upgrade.php --non-interactive
   ```

3. Confirm the plugin appears under **Site administration > Plugins > Blocks > Manage blocks**.

## Adding the block

1. Log in as a user with permission to edit the target page.
2. Go to the Moodle page where the block should appear, such as the Dashboard, My courses, or a course page.
3. Turn editing on.
4. Open the block drawer or block add menu.
5. Choose **Skills card**.
6. Move the block to the desired region if needed.

The block supports multiple instances, so it can be added to more than one page or region where Moodle allows blocks.

## Viewing another user's block data

Site administrators can view another user's block data when the page request includes a valid Moodle `id` parameter for that user. Non-admin users cannot use this parameter to view another user's data.

## Development notes

* Component name: `block_skillscard`
* Main block class: `block_skillscard`
* Language file: `lang/en/block_skillscard.php`
* Current block title string: `Skills card`
* Current plugin version: `2026052101`

Run syntax checks before committing changes:

```bash
php -l block_skillscard.php
php -l version.php
php -l lang/en/block_skillscard.php
php -l classes/privacy/provider.php
php -l db/access.php
```

## Author And Licence
*   **Author:** Vinny Stocker <vinny@pukunui.com> (and original contributors)
*   **Copyright:** 2026 Pukunui Malaysia (and original copyright holders)
*   **Licence:** GNU GPL v3 or later
*   **Component:** `block_skillscard`
