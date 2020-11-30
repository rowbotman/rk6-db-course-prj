import * as React from 'react';
import * as cn from 'classnames';

import * as s from './Header.scss';
import * as i from 'Styles/icon.scss';

export const Header = () => (
	<div className={s.header}>
		<div className={cn(s.header, s.header_main)}>
			<i className={cn(i.icon, i.icon_color_white, i.icon_size_headerFit, i.icon_type_archive)}/>
			<a className={s.header__title} href="/">COURSACHEIT</a>
		</div>
		<a className={s.header__exit} href="/exit">Выход</a>
	</div>
);
