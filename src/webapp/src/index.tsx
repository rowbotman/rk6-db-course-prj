import * as React from 'react';

import { render } from 'react-dom';

const App = () => (<p>Hello React</p>);

const root = document.getElementById('root');
render(<App/>, root);
