export default function TagList({ tags }) {
    return (
        <div className="flex flex-wrap gap-2">
            {tags.map((tag) => (
                <div
                    key={tag.id}
                    className="flex items-center gap-2 px-3 py-1 rounded-full"
                    style={{ backgroundColor: tag.color || '#e5e7eb' }}
                >
                    {tag.icon && <span className={tag.icon}></span>}
                    <span>{tag.name}</span>
                </div>
            ))}
        </div>
    );
}
