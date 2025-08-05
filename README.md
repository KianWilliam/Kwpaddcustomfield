# Kwpaddcustomfield
A Joomla 5.x plugin which adds a modal window containing the list of a core or custom component to the chosen extensions in the site backend.
The extension is of use for developers in case of using the data of an item in a component list in an extension backend.
If the modal is to be appeared in the backend form of a core or custom component, there may be needed to add:
<?php ehco $this->form->renderFieldset('params') ?>
To the layout of that extension backend. (Better to add the line to the layout override)
In case of module and plugin extensions there is not need to update anything.
