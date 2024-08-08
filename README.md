# Argon Dokuwiki Template

Forked from: [IceWreck/Argon-Dokuwiki-Template](https://github.com/IceWreck/Argon-Dokuwiki-Template) -> [Mickeel/Argon-Dokuwiki-Template/](https://github.com/IceWreck/Argon-Dokuwiki-Template) -> [https://github.com/ahmetsacan/dokuwiki-template-argon](https://github.com/ahmetsacan/dokuwiki-template-argon). Also see [other forks](https://github.com/IceWreck/Argon-Dokuwiki-Template/network).

Changes made by Ahmet:
* Fixed some javascript errors that were popping up about PerfectScrollbar.
* Added (close to) full customization of what is shown where. For each of the navbar, sidebar, footer, and contenttop sections, you can control what is shown. The things to show include pageicons, siteicons, usericons, pagetools, sitetools, usertools (these *tools appear as list items as opposed to icons), searchform, breadcrumbs, sidebarpage, pageinfo, userinfo, and any wiki page. These all can be controlled in the admin configuration page.
* Added printview functionality to show just the main page content if the URL contains 'printview' parameter.  When in printview, there is also a hack to inject the printview=1 parameter into all of the links shown on the page. Printview and the link injections options are off by default; you can turn them on in the admin configuration page.
* Added option to hide the first title of the page, when URL contains 'notitle' parameter. Together with printview, I find this useful when embedding the page elsewhere in an iframe. The notitle functionalify is off by default; you can turn it on in the admin configuration page.






Argon - a clean, responsive, modern template for Dokuwiki.
https://www.dokuwiki.org/template:argon

![Screenshot](screenshots/1.png)

## Sidebar

If you have a sidebar, then put your links (in the sidebar) in bullet points to ensure consistent styling with the rest of the template.

## Styling

I've imported the base stylesheet from the argon design system and then added custom styles on top in the ___assets/css/doku.scss___ file. The file is then compiled to CSS using SASS.

To do changes and have it compile live, do
```
sass --watch assets/css/doku.scss assets/css/doku.css
```

## Contributors

- [IceWreck](https://github.com/IceWreck)
- [SoarinFerret](https://github.com/SoarinFerret)
- [llune](https://github.com/llune)

## Credits
* Creative Tim for the [Argon Design System](https://github.com/creativetimofficial/argon-design-system) stylesheet. 
* [Anika Henke](https://github.com/selfthinker) for her starter dokuwiki template.

## More Screenshots

![Screenshot](screenshots/2.png)
![Screenshot](screenshots/3.png)
![Screenshot](screenshots/4.png)
![Screenshot](screenshots/5.png)
