import '@elderbraum/rvk-elements';
import React from 'react';
import ReactDOM from 'react-dom';

ReactDOM.render(React.createElement(
	rvkElements.Input.Stars,
	{
		input: {
			id:'score'
		}
	}
	),
	document.querySelector('.re-star-input')
);

ReactDOM.render(
	React.createElement(
		rvkElements.Stars,
		{
			score: document.querySelector('.rvk--review__score').innerHTML,
			color: '#f93'
		}
		),
	document.querySelector('.re-star-output')
)
