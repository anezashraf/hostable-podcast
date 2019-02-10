import React from 'react'
import {bindActionCreators} from "redux";
import {fetchEpisodes, updateEpisode} from "../modules/episode";
import {connect} from "react-redux";
import EpisodeForm from '../Components/Forms/EpisodeForm'


class Episodes extends React.Component {

    componentDidMount() {
        this.props.fetchEpisodes()
    }


    render() {
        let {episodes, updateEpisode} = this.props;
        console.log(this.props);

        return (
            <section>
                    {episodes.map((value, index) => {
                        return(
                            <EpisodeForm key={index} episode={value} handleSave={updateEpisode} />
                            )
                    })}
            </section>
        )
    }
}


const mapStateToProps = ({ episode }) => ({
    episodes: episode.episodes
});

const mapDispatchToProps = dispatch =>
    bindActionCreators(
        {
            fetchEpisodes,
            updateEpisode
        },
        dispatch
    );

export default connect(
    mapStateToProps,
    mapDispatchToProps
)(Episodes)