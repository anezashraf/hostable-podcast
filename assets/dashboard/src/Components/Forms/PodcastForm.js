import React from 'react'

class PodcastForm extends React.Component {

    constructor(props) {
        super(props);

        this.state = {
            title: '',
            description: ''
        }
    }

    componentDidMount() {
        let {title, description} = this.props;

        this.setState({title: title, description: description});
    }

    handleTitleChange = (e) => {
        this.setState({title: e.target.value});
    };

    handleDescriptionChange = (e) => {
        this.setState({description: e.target.value});
    };

    handleSave = (e) => {
        e.preventDefault();
        this.props.handleSave(this.state.title, this.state.description, this.props.id)
    }

    render() {

        let {title, description} = this.state;

        return (
                <form onSubmit={this.handleSave}>
                    <input type="text" name="title" value={title} onChange={this.handleTitleChange}/>
                    <input type="text" name="description" value={description} onChange={this.handleDescriptionChange}/>
                    <button type="submit">Save</button>
                </form>
        )
    }
}

export default PodcastForm